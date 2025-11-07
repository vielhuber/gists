'use strict';

class MailMaintenanceService {
    static CONFIG = {
        PURGE_INTERVAL_MS: 30 * 60 * 1000, // 30 minutes
        OPERATION_DELAY_MS: 100, // Delay between operations
        INITIAL_DELAY_MS: 5000, // Initial startup delay
        LOG_PREFIX: '[MailMaintenance]',
        FOLDER_FILTERS: {
            // Uncomment to filter specific accounts
            // INCLUDE_PATTERN: '...',
            EXCLUDE_PATTERNS: ['/Trash', '/Junk', '/Spam']
        }
    };

  static EXIT_CODES = {
        SUCCESS: 0,
        FAILURE: -1
    };

    static OPERATIONS = {
        UPDATE: 'UPDATE',
        COMPACT: 'COMPACT'
    };

    constructor() {
        this.intervalId = null;
        this.isRunning = false;
        this.statistics = {
            lastRun: null,
            totalRuns: 0,
            totalFoldersProcessed: 0,
            totalErrors: 0,
            currentSession: {
                foldersProcessed: 0,
                errors: []
            }
        };
        this.logger = new Logger(MailMaintenanceService.CONFIG.LOG_PREFIX);
    }

    start() {
        if (this.intervalId) {
            this.logger.warn('Service already running');
            return;
        }

        this.logger.info('Starting Mail Maintenance Service');
        
        // Schedule periodic execution
        this.intervalId = setInterval(
            () => this.performMaintenance(),
            MailMaintenanceService.CONFIG.PURGE_INTERVAL_MS
        );

        // Perform initial maintenance after startup delay
        setTimeout(
            () => this.performMaintenance(),
            MailMaintenanceService.CONFIG.INITIAL_DELAY_MS
        );
    }

    stop() {
        if (!this.intervalId) {
            this.logger.warn('Service not running');
            return;
        }

        clearInterval(this.intervalId);
        this.intervalId = null;
        this.logger.info('Stopped Mail Maintenance Service');
    }

    async performMaintenance() {
        if (this.isRunning) {
            this.logger.warn('Maintenance already in progress, skipping');
            return;
        }

        this.isRunning = true;
        this.statistics.currentSession = {
            foldersProcessed: 0,
            errors: []
        };

        const startTime = performance.now();
        
        try {
            this.logger.info('Starting maintenance cycle');
            
            const folders = this.getEligibleFolders();
            await this.processFolders(folders);
            
            const duration = Math.round(performance.now() - startTime);
            this.updateStatistics(duration);
            
            this.logger.info(`Maintenance completed in ${duration}ms`, {
                foldersProcessed: this.statistics.currentSession.foldersProcessed,
                errors: this.statistics.currentSession.errors.length
            });
            
        } catch (error) {
            this.logger.error('Critical error during maintenance', error);
        } finally {
            this.isRunning = false;
        }
    }

    getEligibleFolders() {
        const folders = [];
        
        for (const folder of MailServices.accounts.allFolders) {
            if (this.shouldProcessFolder(folder)) {
                folders.push(folder);
            }
        }
        
        this.logger.debug(`Found ${folders.length} eligible folders`);
        return folders;
    }

    shouldProcessFolder(folder) {
        // Skip virtual folders
        if (folder.flags & Components.interfaces.nsMsgFolderFlags.Virtual) {
            return false;
        }

        const { FOLDER_FILTERS } = MailMaintenanceService.CONFIG;
        
        // Apply include filter if defined
        if (FOLDER_FILTERS.INCLUDE_PATTERN) {
            if (!folder.URI.includes(FOLDER_FILTERS.INCLUDE_PATTERN)) {
                return false;
            }
        }

        // Apply exclude filters
        for (const pattern of FOLDER_FILTERS.EXCLUDE_PATTERNS) {
            if (folder.URI.includes(pattern)) {
                return false;
            }
        }

        return true;
    }

    async processFolders(folders) {
        for (const folder of folders) {
            try {
                await this.processFolder(folder);
                this.statistics.currentSession.foldersProcessed++;
            } catch (error) {
                this.handleFolderError(folder, error);
            }
        }
    }

    async processFolder(folder) {
        this.logger.debug(`Processing: ${folder.URI}`);
        
        // Update IMAP folders
        if (folder.server.type === 'imap') {
            await this.updateFolder(folder);
            await this.delay(MailMaintenanceService.CONFIG.OPERATION_DELAY_MS);
        }
        
        // Compact folder
        await this.compactFolder(folder);
        await this.delay(MailMaintenanceService.CONFIG.OPERATION_DELAY_MS);
    }

    async updateFolder(folder) {
        return new Promise((resolve, reject) => {
            // Check if folder supports updates
            if (!folder.canFileMessages) {
                resolve();
                return;
            }

            const operation = new FolderOperation(
                folder,
                MailMaintenanceService.OPERATIONS.UPDATE
            );

            folder.downloadAllForOffline(
                {
                    OnStartRunningUrl: (url) => {
                        operation.onStart(url);
                    },
                    OnStopRunningUrl: (url, exitCode) => {
                        operation.onComplete(url, exitCode);
                        
                        if (exitCode === MailMaintenanceService.EXIT_CODES.SUCCESS) {
                            resolve();
                        } else {
                            reject(new Error(
                                `Update failed for ${folder.URI} with code ${exitCode}`
                            ));
                        }
                    }
                },
                null
            );
        });
    }

    async compactFolder(folder) {
        return new Promise((resolve, reject) => {
            // Check if folder supports compaction
            if (!folder.canCompact) {
                resolve();
                return;
            }

            const operation = new FolderOperation(
                folder,
                MailMaintenanceService.OPERATIONS.COMPACT
            );

            folder.compact(
                {
                    OnStartRunningUrl: (url) => {
                        operation.onStart(url);
                    },
                    OnStopRunningUrl: (url, exitCode) => {
                        operation.onComplete(url, exitCode);
                        
                        if (exitCode === MailMaintenanceService.EXIT_CODES.SUCCESS) {
                            resolve();
                        } else {
                            reject(new Error(
                                `Compaction failed for ${folder.URI} with code ${exitCode}`
                            ));
                        }
                    }
                },
                null
            );
        });
    }

    handleFolderError(folder, error) {
        const errorInfo = {
            folder: folder.URI,
            error: error.message,
            timestamp: new Date().toISOString()
        };
        
        this.statistics.currentSession.errors.push(errorInfo);
        this.logger.error(`Failed to process folder: ${folder.URI}`, error);
    }

    updateStatistics(duration) {
        this.statistics.lastRun = new Date();
        this.statistics.totalRuns++;
        this.statistics.totalFoldersProcessed += 
            this.statistics.currentSession.foldersProcessed;
        this.statistics.totalErrors += 
            this.statistics.currentSession.errors.length;
    }

    async delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    getStatistics() {
        return { ...this.statistics };
    }
}

class FolderOperation {
    constructor(folder, type) {
        this.folder = folder;
        this.type = type;
        this.startTime = null;
    }

    onStart(url) {
        this.startTime = performance.now();
        // Log start if needed
    }

    onComplete(url, exitCode) {
        const duration = Math.round(performance.now() - this.startTime);
        
        if (exitCode === MailMaintenanceService.EXIT_CODES.SUCCESS) {
            console.log(
                `${MailMaintenanceService.CONFIG.LOG_PREFIX} ` +
                `${this.type} completed for ${this.folder.URI} in ${duration}ms`
            );
        } else {
            console.warn(
                `${MailMaintenanceService.CONFIG.LOG_PREFIX} ` +
                `${this.type} failed for ${this.folder.URI} ` +
                `with code ${exitCode} after ${duration}ms`
            );
        }
    }
}

class Logger {
    constructor(prefix) {
        this.prefix = prefix;
    }

    info(message, data) {
        console.log(`${this.prefix} ${message}`, data || '');
    }

    debug(message, data) {
        // Uncomment for debug logging
        // console.debug(`${this.prefix} [DEBUG] ${message}`, data || '');
    }

    warn(message, data) {
        console.warn(`${this.prefix} [WARN] ${message}`, data || '');
    }

    error(message, error) {
        console.error(`${this.prefix} [ERROR] ${message}`, error || '');
    }
}

// Create and start the service
const mailMaintenanceService = new MailMaintenanceService();
mailMaintenanceService.start();

// Export for external access (if needed)
if (typeof window !== 'undefined') {
    window.MailMaintenanceService = mailMaintenanceService;
}

// Cleanup on shutdown (for userChrome.js environments)
if (typeof Services !== 'undefined') {
    Services.obs.addObserver({
        observe(subject, topic, data) {
            if (topic === 'quit-application-granted') {
                mailMaintenanceService.stop();
            }
        }
    }, 'quit-application-granted');
}