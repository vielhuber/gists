Get-ScheduledTask -TaskPath '\' | ForEach-Object {
  $xml = [xml](Export-ScheduledTask -TaskName $_.TaskName -TaskPath $_.TaskPath -ErrorAction SilentlyContinue)
  $node = $xml.SelectSingleNode("/*[local-name()='Task']/*[local-name()='Settings']/*[local-name()='Priority']")
  $p = 7
  if ($node -and $node.InnerText) { $p = [int]$node.InnerText }
  [pscustomobject]@{
    Task     = "$($_.TaskPath)$($_.TaskName)".TrimStart('\')
    Priority = $p
  }
} | Format-Table -Auto
