<div class="container principal">
  <h1>CURSOS</h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Categoria</th>
        <th>Clave</th>
        <th>Nombre</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($cursos as $key => $curso) { ?>
      <tr>
        <th scope="row"><?= $key+1 ?></th>
        <td><?= $curso['name'] ?></td>
        <td><?= $curso['shortname'] ?></td>
        <td><?= $curso['fullname'] ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
