import { buildTemplate } from "../modules/buildTemplate.js";

buildTemplate();


const ytPlayer = document.getElementById("ytPlayer");

ytPlayer.src = "https://www.youtube.com/embed/N5dEU2zqOOA?autoplay=1&mute=1";

console.log(ytPlayer);
console.log("test");