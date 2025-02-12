# Flappy bird
Projekt je hostován na adrese [bird.7dub.dev](https://bird.7dub.dev).

## Obsah
- [Instalace](#instalace)
  - [NixOS](#nixos)
  - [Manuální](#manuální)
- [Konfigurace](#konfigurace)
- [Běžné problémy](#běžné-problémy)
- [Poděkování](#poděkování)

# Instalace

## NixOS
V případě instalace na NixOS stačí pouze naklonovat repozitář do `/srv/caddy` a
importovat modul `deploy.nix` do `configuration.nix` nebo `flake.nix`.  
Toto vytvoří systémovou systemd jednotku `caddy.service` ve které běží Caddy
(FrankenPHP) na portech 80 a 443 a další systémovou jednotku `mysql.service`.  

### Vývojové prostředí
Pokud chcete pouze lokální server pro vývoj, spusťte `nix develop` a spustí se
server s lokálním SSL certifikátem jako `SCREEN(1)` s názvem `php`. Server si
můžete zobrazit pomocí `screen -r php`.

## Manuální
Nainstalujte FrankenPHP dle [jejich dokumentace](https://frankenphp.dev/docs/).  
Nainstalujte MySQL databázi. (doporučuji [MariaDB](https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/))  
Naklonujte tento repozitář.  
Spusťte `./SQL/create.sql` pro vytvoření databáze a nastavte proměnné prostředí
`DOMAIN` a `PORT` ve formátech `<doména>:<HTTPS port>` a `<HTTP port>`
respektive.  
Webserver spusťte pomocí příkazu `php frankenphp run --envfile ./.env` ve
složce, kam jste dříve naklonoval tento repozitář.



# Konfigurace

## E-Mail
Pro funkční email je nutné vytvořit soubor `.env` a nastavit v něm SMTP
heslo jako `EMAIL_PASSWORD=<heslo>`. Pokud chcete použít jinou adresu než
"noreply@7dub.dev" nebo jiný SMTP server než "smtp.gmail.com", musíte změnit
konfiguraci v `./src/send_email.php`.

## Doména a porty (NixOS)
Pro změnu očekávané domény (kvůli SSL certifikátu) nebo portu (pro vyhnutí
privilegovaným portům 0-1023), lze použít proměnné prostředí `DOMAIN` a `PORT`
ve formátech `<doména>:<HTTPS port>` a `<HTTP port>` respektive. Tyto proměnné
by měly být nastavené přes `systemd.services.caddy.serviceConfig.Environment`
v `deploy.nix`.

## Databáze
Aplikace předpokládá, že databáze je přístupná na `localhost:3306` s uživatelem
`root` s heslem `root`. Případné změny musíte provést v souboru `./src/db.php`.



# Běžné problémy

## Instalace pomocí modulu NixOS
### Chyba certifikátu/TLS - permission denied
Ujistěte se, že uživatel `caddy` nebo skupina `caddy` má povolení upravovat
soubory ve složce `/srv/cadddy`.  
Jedním řešením je učinit uživatele `caddy` vlastníkem těchto složek: `sudo chown
caddy: /srv/caddy -R`.

### Neexistuje databáze flappy_bird
Modul by měl sám spustit skript na vytvoření databáze, ale nenastane-li tak, je
nutné `./SQL/create.sql` spustit manuálně.

## Manuální instalace
### Chyba certifikátu
Caddy se pokusí získat SSL certifikát na doménu určenou v `DOMAIN` pomocí [Let's
Encrypt](https://letsencrypt.org/), což znamená, že musí webserver odpovídat na
požadavky na danou adresu. Tato chyba by tedy mohla vzniknout :
  - špatně přesměrovanými porty
  - omezujícími pravidly firewallu
  - špatnou doménou v `DOMAIN`

Není-li veřejný SSL certifikát vyžadovaný, je možné nastavit `DOMAIN` jako
`localhost:<HTTPS port>`, což vystaví lokálně podepsaný certifikát.



# Poděkování
- Textury: [samuelcust/flappy-bird-assets](https://github.com/samuelcust/flappy-bird-assets)
- E-Mail: [PHPMailer](https://github.com/PHPMailer/PHPMailer)
