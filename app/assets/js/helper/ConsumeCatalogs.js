$(document).ready(function () {
    

  Catalog.getObject(url + 'Register/getStateAll','idstate','description','#estadoNacimiento');

  Catalog.getObject(url + 'Register/getStateAll','idstate','description','#estadoRadica');
  Utils.changeComboData('#estadoRadica',url + 'Register/getTownByIdState/?data=', 'idtown','description','#municipio');
  Utils.changeComboData('#municipio',url + 'Register/getLocalityByIdTown/?data=', 'idlocality','description', '#localidad');

  Catalog.getObject(url + 'Register/getAcademicLevelAll','idacademiclevel','description',"#nivelAcademico", true);



});
