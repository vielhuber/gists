# arguments
param(
    [string]$device,
    [string]$type)

# self elevate to admin
if (!([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Start-Process powershell.exe "-NoProfile -ExecutionPolicy Bypass -File `"$PSCommandPath`" -device `"$device`" -type `"$type`"" -Verb RunAs; exit
}

# get device
$d = Get-PnpDevice | where { $_.friendlyname -like $device -or $_.instanceid -like $device }

# output device
$d

if ($type -eq "enable") {
    "ENABLING $d"
    $d | Enable-PnpDevice -Confirm:$false
}
else {
    "DISABLING $d"
    $d | Disable-PnpDevice -Confirm:$false
}

# status message
"ok"

# small pause
Start-Sleep -s 2