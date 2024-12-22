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
      ];

      shellHook = ''
        screen -dmS php frankenphp php-server --listen localhost:3000
        fish
      '';
    };
  };
}
