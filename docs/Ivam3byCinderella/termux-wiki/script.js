const howToDirectory = 'how-to/';

const addRecentHowTos = () => {
  // Obtener los nombres de los archivos en el directorio de how-tos
  fetch(howToDirectory)
    .then(response => response.text())
    .then(data => {
      // Crear un objeto DOM con el HTML de la respuesta
      const parser = new DOMParser();
      const html = parser.parseFromString(data, 'text/html');

      // Obtener los enlaces a los archivos
      const fileLinks = [...html.querySelectorAll('a')]
        .filter(a => a.href.endsWith('.md') || a.href.endsWith('.txt'))
        .map(a => ({
          name: a.textContent,
          url: a.href,
        }));

      // Ordenar los enlaces por fecha de modificación (los más recientes primero)
      fileLinks.sort((a, b) => {
        const dateA = new Date(a.lastModified);
        const dateB = new Date(b.lastModified);
        return dateB - dateA;
      });

      // Crear una lista de elementos <li> con los enlaces
      const listItems = fileLinks.map(({ name, url }) => {
        const link = document.createElement('a');
        link.href = url;
        link.textContent = name;

        const listItem = document.createElement('li');
        listItem.appendChild(link);

        return listItem;
      });

      // Insertar los elementos <li> en la lista de "Últimos how-tos"
      const howToList = document.querySelector('ul');
      howToList.innerHTML = '';
      listItems.forEach(item => howToList.appendChild(item));
    });
};

window.addEventListener('load', addRecentHowTos);

