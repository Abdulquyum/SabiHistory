Set-StrictMode -Version Latest
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
$url = 'https://storage.googleapis.com/flutter_infra_release/releases/stable/windows/flutter_windows_3.44.0-stable.zip'
$out = 'C:\src\flutter.zip'
New-Item -Path 'C:\src' -ItemType Directory -Force | Out-Null
Write-Host "Downloading $url to $out (this can take several minutes)"
try {
  Invoke-WebRequest -Uri $url -OutFile $out -UseBasicParsing -TimeoutSec 1800 -Verbose
  Write-Host 'Download finished'
} catch {
  Write-Host 'Download failed:' $_.Exception.Message
}
