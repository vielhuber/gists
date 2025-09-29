$tasks = @("Task1", "Task2", "Task3")
$priority = 4

$tasks | ForEach-Object {
    $taskName = $_
    try {
        $currentTask = Get-ScheduledTask -TaskName $taskName -ErrorAction Stop
        $settings = $currentTask.Settings
        $settings.Priority = $priority
        Set-ScheduledTask -TaskName $taskName -TaskPath $currentTask.TaskPath -Settings $settings
        Write-Host "[OK] $taskName - Set priority to $priority." -ForegroundColor Green
    } catch {
        Write-Host "[ERROR] $taskName - Not found." -ForegroundColor Red
    }
}