``` powershell

Get-ChildItem -Path "Cert:\CurrentUser\Root" -Recurse | where { $_.GetType() -eq [System.Security.Cryptography.X509Certificates.X509Certificate2] } | where {$_.Subject -like "*Zscaler*"} | Export-Certificate -FilePath .\zScaler.cer -Type CERT
certutil.exe -encode .\zScaler.cer .\zScaler_Base64.cer
Remove-Item .\zScaler.cer
Remove-Item $env:APPDATA\zScaler.cer
Move-Item .\zScaler_Base64.cer $env:APPDATA\zScaler.cer -Force
git config --global http.sslcainfo $env:APPDATA\zScaler.cer
npm config set cafile $env:APPDATA\zScaler.cer
ionic config set -g ssl.cafile $env:APPDATA\zScaler.cer

```