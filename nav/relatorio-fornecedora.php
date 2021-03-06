<?php require_once "config.php"; $pdo = conectar(); require_once "function.php"; ?> 

<section>
<div id="janela">
<legend>Relátorio das Fornecedoras</legend>


<!-- Formulario de Pesquisa em Jquery-->
 <form method="post" action="exemplo.html" class="pesquise" >     
 <input type="text" id="pesquisar" name="pesquisar" class="form-control" autofocus  placeholder="Digite o Nome do Técnico" />
 </form>
<!-- Fecha Formulario-->

<table class="table table-striped table-hover">

<thead>
<tr>
<th>Fornecedora</span></th>
<th>CNPJ</span></th>
<th>Contato</span></th>
<th>Telefone</span></th>
<th>Site</span></th>

<th class="centro-table">Editar</th>
</tr>
</thead>
<?php 

$consulta = $pdo->query("SELECT * FROM fornecedoras ORDER BY nome ASC ");
$consulta->execute();

while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){

?>

<tr>
<td><?php echo $linha['nome']?></td>
<td><?php echo $linha['cnpj']?></td>
<td><?php echo $linha['contato']?></td>
<td><?php echo $linha['telefone']?></td>
<td><?php echo $linha['sites']?></td>
<!-- <td class="centro-table"><a href="?pg=detail-cliente&id_tecnico=<?php echo $linha['id_tecnico'];?>"><span class="glyphicon glyphicon-new-window"></span></a></td> -->
<!-- <td class="centro-table"><a href="?pg=detail-compras&id_tecnico=<?php echo $linha['id_tecnico'];?>"><span class="glyphicon glyphicon-th-list"></span></a></td> -->
<td class="centro-table"><a href="?pg=update-fornecedora&id_fornecedora=<?php echo $linha['id_fornecedora'];?>"><img src="icon/edit.png"></a></td>

</tr>



<?php } ?>

</table>
 


    </div>
  </section>


 <!-- Paginação em Jquery-->

    
    <script>
    $(function(){
      
      $('table > tbody > tr:odd').addClass('odd');
      
      $('table > tbody > tr').hover(function(){
        $(this).toggleClass('hover');
      });
      
      $('#marcar-todos').click(function(){
        $('table > tbody > tr > td > :checkbox')
          .attr('checked', $(this).is(':checked'))
          .trigger('change');
      });
      
      $('table > tbody > tr > td > :checkbox').bind('click change', function(){
        var tr = $(this).parent().parent();
        if($(this).is(':checked')) $(tr).addClass('selected');
        else $(tr).removeClass('selected');
      });
      
      $('form').submit(function(e){ e.preventDefault(); });
      
      $('#pesquisar').keydown(function(){
        var encontrou = false;
        var termo = $(this).val().toLowerCase();
        $('table > tbody > tr').each(function(){
          $(this).find('td').each(function(){
            if($(this).text().toLowerCase().indexOf(termo) > -1) encontrou = true;
          });
          if(!encontrou) $(this).hide();
          else $(this).show();
          encontrou = false;
        });
      });
      
      $("table") 
        .tablesorter({
          dateFormat: 'uk',
          headers: {
            0: {
              sorter: false
            },
            5: {
              sorter: false
            }
          }
        }) 
        .tablesorterPager({container: $("#pager")})
        .bind('sortEnd', function(){
          $('table > tbody > tr').removeClass('odd');
          $('table > tbody > tr:odd').addClass('odd');
        });
      
    });
    </script>
<!-- Fecha Paginação-->

</div><!-- Fecha Id conteudo-->
</div><!-- Fecha Id Janela-->
</section>