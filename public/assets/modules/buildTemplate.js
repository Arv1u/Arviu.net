import { loadComponent } from "./loadComponent.js";

// Requires empty divs with id "navbar" and "footer". Fills empty divs with component templates.
export function buildTemplate(){
    loadComponent("navbar", "./assets/templates/navbar.html");
    loadComponent("footer", "./assets/templates/footer.html");
}
