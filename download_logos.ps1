$urls = @(
    'https://civilanka.com/uploads/logos/logo_6a3bad76eafe28.21349305.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3bad5a6c9a02.13187782.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3bad48c67e40.02405538.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3bad35666e06.11957914.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3bad27b9de38.76631544.png',
    'https://civilanka.com/uploads/logos/logo_6a3bad19e8dbb5.78825162.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3bad0c67e525.84899538.png',
    'https://civilanka.com/uploads/logos/logo_6a3bacf3aa2e46.12771378.png',
    'https://civilanka.com/uploads/logos/logo_6a3bac7a5a69e5.79779457.png',
    'https://civilanka.com/uploads/logos/logo_6a3bac6b237270.37936484.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3bac5bd72539.14685798.jpg',
    'https://civilanka.com/uploads/logos/logo_6a43b3ce4036a9.00932853.png',
    'https://civilanka.com/uploads/logos/logo_6a3bac11af5993.43430116.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3babfba214c6.16496199.jpg',
    'https://civilanka.com/uploads/logos/logo_6a3babebbdf290.27183116.png',
    'https://civilanka.com/uploads/logos/logo_6a3babdde8a177.51262754.png',
    'https://civilanka.com/uploads/logos/logo_6a3bab197c6bd1.36913317.png',
    'https://civilanka.com/uploads/logos/logo_6a3bab53950272.13239386.png',
    'https://civilanka.com/uploads/logos/logo_6a3baa868d1380.46961839.png',
    'https://civilanka.com/uploads/logos/logo_6a3baa7d484fb5.94758977.png',
    'https://civilanka.com/uploads/logos/logo_6a3ba0d45d4b11.99581543.png',
    'https://civilanka.com/uploads/logos/logo_6a3ba0bae18230.48420255.png',
    'https://civilanka.com/uploads/logos/logo_6a3ba0aee35e15.23455713.png',
    'https://civilanka.com/uploads/logos/logo_6a3ba00d6663c2.29865339.png'
)
foreach ($url in $urls) {
    $name = $url.Split('/')[-1]
    $out = "assets/images/partners/$name"
    try {
        Invoke-WebRequest -Uri $url -OutFile $out -UseBasicParsing
        Write-Host "Downloaded $name"
    } catch {
        Write-Host "Failed to download $url"
    }
}
