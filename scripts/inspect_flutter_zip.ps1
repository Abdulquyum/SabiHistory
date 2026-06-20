Set-StrictMode -Version Latest
$zip = 'C:\src\flutter.zip'
if (Test-Path $zip) {
  Write-Host 'SHA256:'
  Get-FileHash -Algorithm SHA256 $zip
  Write-Host ""
  Write-Host 'Attempting Expand-Archive...'
  try {
    Expand-Archive -Path $zip -DestinationPath 'C:\src' -Force
    Write-Host 'Expand-Archive: OK'
  } catch {
    Write-Host 'Expand-Archive failed:'
    Write-Host $_.Exception.Message
    if ($_.Exception.InnerException) { Write-Host 'Inner:'; Write-Host $_.Exception.InnerException.Message }
  }
} else {
  Write-Host 'No zip found at' $zip
}

if (Test-Path 'C:\Program Files\7-Zip\7z.exe') { Write-Host 'Found 7z at C:\Program Files\7-Zip\7z.exe' }
elseif (Test-Path 'C:\Program Files (x86)\7-Zip\7z.exe') { Write-Host 'Found 7z at C:\Program Files (x86)\7-Zip\7z.exe' }
else {
  try { Get-Command 7z.exe -ErrorAction Stop | Out-Null; Write-Host '7z.exe is in PATH' } catch { Write-Host '7z.exe not found' }
}
