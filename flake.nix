{
  inputs.nixpkgs.url = "github:nixos/nixpkgs?ref=nixos-unstable";

  outputs = {nixpkgs, ...}: let
    system = "x86_64-linux";
    pkgs = nixpkgs.legacyPackages.${system};
  in {
    devShells.${system}.default = pkgs.mkShell {
      name = "php";

      buildInputs = with pkgs; [
        frankenphp
        nss
      ];

      shellHook = ''
        export DOMAIN=localhost:3000
        export PORT=3080
        screen -dmS php frankenphp run --envfile ./.env
      '';
    };
  };
}
