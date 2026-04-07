export async function loadComponent(id, file) {
    const templateFile = await fetch(file);
    const data = await templateFile.text(); 

    document.getElementById(id).innerHTML = data;
}