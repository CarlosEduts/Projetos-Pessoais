const canvas = document.querySelector("#canvas");
const ctx = canvas.getContext("2d");

const pixel = 32;

let jogador = {
  x: 0,
  y: 0,
};

let encontro = {
  x: [],
  y: [],
  saida: [],
  verificar: [],
};
const cores = {
  jogador: "#222d33",
  parede: "#000",
  fundo: "#899ba5",
  saida: "#f2e935",
};

// Laberinto 4x5
// ####
// @...
// ###.
// ....
// o###

const level = `####@...###.....o###`;
const width = 4;

canvas.height = (level.length / width + 2) * pixel;
canvas.width = width * pixel;

const gerarCenario = () => {
  let eixoX = 0;
  let eixoY = 0;
  encontro.x = [];
  encontro.y = [];
  encontro.saida = [];

  for (item in level) {
    if (item % width == 0) {
      eixoY += 1;
      eixoX = 0;
    } else {
      eixoX += 1;
    }

    switch (level[item]) {
      case "#":
        ctx.fillStyle = cores.parede;
        encontro.x.push(eixoX);
        encontro.y.push(eixoY);
        break;
      case "o":
        ctx.fillStyle = cores.saida;
        encontro.saida.push(eixoX);
        encontro.saida.push(eixoY);
        break;
      case ".":
        ctx.fillStyle = cores.fundo;
        break;
      default:
        ctx.fillStyle = cores.fundo;
        break;
    }

    console.log(`${item}: ${level[item]}, x: ${eixoX}, y; ${eixoY}`);
    ctx.fillRect(eixoX * pixel, eixoY * pixel, pixel, pixel);
  }
};

const gerarJogador = (jogadorX, jogadorY) => {
  let eixoX = 0;
  let eixoY = 0;

  ctx.clearRect(0, 0, width * pixel, (level.length / width + 2) * pixel);
  gerarCenario();

  for (item in level) {
    if (item % width == 0) {
      eixoY += 1;
      eixoX = 0;
    } else {
      eixoX += 1;
    }

    if (level[item] === "@") {
      ctx.fillStyle = cores.jogador;
      break;
    }
  }

  for (var i = 0; i < encontro.y.length; i++) {
    if (
      encontro.y[i] == eixoY + jogadorY &&
      encontro.x[i] == eixoX + jogadorX
    ) {
      encontro.verificar = true;
      break;
    }
  }

  if (
    encontro.saida[0] == eixoX + jogadorX &&
    encontro.saida[1] == eixoY + jogadorY
  ) {
    alert("Você Venceu!");
  }

  if (encontro.verificar) {
    ctx.fillRect(eixoX * pixel, eixoY * pixel, pixel, pixel);
    encontro.verificar = false;
    jogador.x = 0;
    jogador.y = 0;
  } else {
    ctx.fillRect(
      (eixoX + jogadorX) * pixel,
      (eixoY + jogadorY) * pixel,
      pixel,
      pixel
    );
  }
  console.log(
    `Posicao do Jogador: W: ${eixoX + jogadorX}, H: ${eixoY + jogadorY}`
  );
};

document.addEventListener("keydown", (e) => {
  switch (e.key) {
    case "ArrowRight":
      jogador.x += 1;
      break;
    case "ArrowLeft":
      jogador.x -= 1;
      break;
    case "ArrowUp":
      jogador.y -= 1;
      break;
    case "ArrowDown":
      jogador.y += 1;
      break;
    default:
      break;
  }
  gerarJogador(jogador.x, jogador.y);
});

gerarJogador(jogador.x, jogador.y);
