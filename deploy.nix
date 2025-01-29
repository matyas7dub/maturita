{ pkgs, lib, ... }: {
  services = {
    caddy = {
      enable = true;
      package = pkgs.frankenphp;
      dataDir = "/srv/caddy";
      configFile = "/srv/caddy/Caddyfile"; # Does nothing; only to disable the default creation
    };

    mysql = {
      enable = true;
      package = pkgs.mariadb;
      initialScript = "/srv/caddy/SQL/create.sql";
    };
  };

  systemd.services.caddy.serviceConfig = {
    WorkingDirectory = "/srv/caddy";
    Environment = "DOMAIN=bird.7dub.dev";
    ExecStart = lib.mkForce [
      ""
      "${pkgs.frankenphp}/bin/frankenphp run --config ./Caddyfile --envfile ./.env"
    ];
    SecureBits = "keep-caps";
    AmbientCapabilities = "CAP_NET_BIND_SERVICE CAP_NET_ADMIN";
    CapabilityBoundingSet = "CAP_NET_BIND_SERVICE CAP_NET_ADMIN";
  };

  networking.firewall = {
    allowedTCPPorts = [ 80 443 ];
  };
}
