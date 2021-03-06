<?php require_once "config.php"; $pdo = conectar(); require_once "function.php";?>

<section>

<div id="janela">
<?php

$data = date('Y-m-d');

$agendadosql = $pdo->prepare("SELECT *, c.nome as nomeCliente from instalacoes as i 
INNER JOIN clientes as c ON c.id_cliente = i.fk_id_cliente
INNER JOIN tecnicos as t ON t.id_tecnico = i.fk_id_tecnico
WHERE i.status_agendamento='agendado' AND
i.data_agendamento='$data'
ORDER BY i.data_agendamento ASC");

$agendadosql->execute();
$total = $agendadosql->rowCount();
?>
<legend>Controle de Agendamento de Hoje <span style="float:right">Total ( <?php echo $total ?> )</span> </legend>

<!-- Formulario de Pesquisa em Jquery-->
<form method="post" action="exemplo.html" class="pesquise" >     
 <input type="text" id="pesquisar" name="pesquisar" class="form-control" autofocus  placeholder="Pesquise" />
 </form>
<!-- Fecha Formulario-->


        <br />
        <label for="">Agendamento em Geral</label>
        <table class="table table-hover">

        <thead>
        <tr>
        <th>iclass</th>
        <th>O.S</th>
        <th>COD</th>
        <th>Nome do Cliente</th>
        <th>Técnico</th>
        <th>Agendado</th>
        <th colspan="4">Funções</th>
        </tr>
        </thead>
       
       <?php 

  
        while($linha = $agendadosql->fetch(PDO::FETCH_ASSOC)){

        ?>

        <tr>
        <td>
          <?php if($linha['status_iclass'] == NULL){ ?>
            
            <a href="?pg=clientes-by-tecnicos-today&iclass&os=<?php echo $linha['id_instalacao'];?>&data=<?php echo $_GET['data']; ?>">
            <span class="glyphicon glyphicon-random" style="color:blue" title="enviado" data-toggle="tooltip"></span>
            </a>
            <?php } else { ?>
            <span class="glyphicon glyphicon-random" style="color:red" title="Nao enviado" data-toggle="tooltip"></span> 
           

          <?php } ?>
        </td>
        <td><?php echo $linha['id_instalacao']?></td>
        <td><?php echo $linha['cod_cliente']?></td>
        <td><?php echo $linha['nomeCliente']?></td>
        <td><?php echo $linha['nome']?></td>
        <td><?php echo $dataBR = dataBR($linha['data_agendamento']);?></td>
        <td class="centro-table"><a href="" aria-hidden="true" data-toggle="modal" data-target="#myModal1<?php echo $linha['id_instalacao']?>" class="glyphicon glyphicon-ok-sign" title="Finalizar" data-toggle="tooltip"></a></td> 
        <td class="centro-table"><a href="" aria-hidden="true" data-toggle="modal" data-target="#myModal2<?php echo $linha['id_instalacao']?>" class="glyphicon glyphicon-info-sign" title="Resolução" data-toggle="tooltip"></a></td>
        <td class="centro-table"><a href="" aria-hidden="true" data-toggle="modal" data-target="#myModal3<?php echo $linha['id_instalacao']?>" class="glyphicon glyphicon-transfer" title="Transferir" data-toggle="tooltip"></a></td> 
        <td class="centro-table"><a href="" aria-hidden="true" data-toggle="modal" data-target="#myModal4<?php echo $linha['id_instalacao']?>" class="glyphicon glyphicon glyphicon-time" title="Reagendar" data-toggle="tooltip"></a></td>
        </tr>
  <!-- Modal -->
  <div class="modal fade" id="myModal1<?php echo $linha['id_instalacao']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Finalizar - <?php echo $linha['nomeCliente']?></h4>
      </div>

      <div style="padding:20px">
          <form method="POST" id="finalizar<?php echo $linha['id_instalacao'];?>" action="?pg=clientes-by-tecnicos-all&between&finalizar">
            <input type="hidden" name="id_cliente" value="<?php echo $linha['id_cliente'] ?>">
            <input type="hidden" name="os" value="<?php echo $linha['id_instalacao'] ?>">
            <input type="hidden" name="data" value="<?php echo $_GET['data']?>">
              <input type="hidden" name="data2" value="<?php echo $_GET['data2']?>">
            Tem certeza que deseja finalizar a o.s de nº <strong><?php echo $linha['id_instalacao']; ?></strong> ?
            <br />  <br />  

            <label for="">Data do fechamenteo</label>
            <input style="width:200px" required name="data_fechamento" type="date" class="form-control">

            <?php 
            $id_instalacao = $linha['id_instalacao'];
            $sqltipo = $pdo->prepare("SELECT tipo from instalacoes as i INNER JOIN clientes as c ON i.fk_id_cliente=c.id_cliente WHERE id_instalacao = '$id_instalacao'");
            $sqltipo->execute();
            $tipo = $sqltipo->fetch(PDO::FETCH_ASSOC);
   
            if($tipo['tipo'] == 'cond'){  ?>
              <br /><br />
              <select class="form-control" name="status_agendamento" id="status_agendamento">
              <option value="finalizado">Normal</option>
              <option value="finalizado2">Condominio Tubulação</option>
              </select>

            <?php } ?>
        
          <br />
          <br />
          <button onclick="document.getElementById('finalizar<?php echo $linha['id_instalacao'];?>').submit()"; class="btn btn-primary">OK</button>  
          </form>
      </div>

    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="myModal2<?php echo $linha['id_instalacao']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Resolução - <?php echo $linha['nomeCliente']?></h4>
      </div>
      <div style="padding:20px">
          <form method="POST" id="motivo<?php echo $linha['id_instalacao'];?>" action="?pg=clientes-by-tecnicos-today&selecionado&resolucao">
            <input type="hidden" name="os" value="<?php echo $linha['id_instalacao'] ?>">
            <input type="hidden" name="id_cliente" value="<?php echo $linha['id_cliente'] ?>">
            <label for="">Motivo</label>
            <select class="form-control" name="motivo">
              <option value="CTO">CTO</option>
              <option value="CANCELOU">CANCELOU</option>
              <option value="INDIS">INDISPONIBILIDADE</option>
              <option value="INFRA">INFRAESTRUTURA</option>
              <option value="REAGENDAR">REAGENDAR</option>
              <option value="REDE">REDE</option>
              <option value="RC">RETORNO DE CLIENTE</option>
            </select>
          

          <br />
          <button onclick="document.getElementById('motivo<?php echo $linha['id_instalacao'];?>').submit()"; class="btn btn-primary">OK</button>  
          </form>
        
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="myModal3<?php echo $linha['id_instalacao']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transferência - <?php echo $linha['nomeCliente']?></h4>
      </div>


      <div style="padding:20px">
      
          <form method="POST" id="transferencia<?php echo $linha['id_instalacao'];?>" action="?pg=clientes-by-tecnicos-today&selecionado&transferencia">
          
              <label for="inputEmail4">Técnico </label>
              <input type="hidden" name="os" value="<?php echo $linha['id_instalacao']?>">

                <select name="id_tecnico" required class="form-control">
                    <option value="">Selecione o Técnico</option>
                    <?php 
                        //Pegando todos Produto na loja
                        $produto = $pdo->query("SELECT * FROM tecnicos WHERE status_tecnico = 'ativo' ORDER BY nome ASC");
                        $produto->execute();
                        while($linha2 = $produto->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        
                        <option value="<?php echo $linha2['id_tecnico'] ?>" <?php echo selected( $_POST['id_tecnico'], $linha2['id_tecnico'] ); ?> ><?php echo $linha2['nome']; ?></option>
                      <?php } ?>
                  </select>
                  <br />
                  
                  <button onclick="document.getElementById('transferencia<?php echo $linha['id_instalacao'];?>').submit()"; class="btn btn-primary">OK</button>  
         
              
          </form>
 
        </div>
 
    </div>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="myModal4<?php echo $linha['id_instalacao']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $linha['nomeCliente']?></h4>
      </div>

      <form method="POST" id="reagendar<?php echo $linha['id_instalacao'];?>" action="?pg=clientes-by-tecnicos-today&selecionado&reagendar">
      <input type="hidden" name="os" value="<?php echo $linha['id_instalacao']?>">

         
          <div style="padding:20px">
          
                    
      
          <label for="">Data de Instalação</label>
          <input style="width:200px" required name="data_agendamento" type="date" class="form-control">
          
            <br />
            <button onclick="document.getElementById('reagendar<?php echo $linha['id_instalacao'];?>').submit()"; class="btn btn-primary">Reagendar</button>  
              </div>    
          </form>
       
      <!-- Parte da mensagem que os dados foram salvos -->
      <div class="modal-body">
        


      </div>

    </div>
  </div>
</div>
<?php }?>
</table>



</div><!-- Fecha Id Janela-->
</section>

<script LANGUAGE="Javascript">  

function enviar0(){
document.getElementById("myForm").submit();
}

</script>  


<?php if (isset($_GET['finalizar'])){

  $os =  $_POST['os'];
  $status_agendamento =  $_POST['status_agendamento'];
  $id_cliente =  $_POST['id_cliente'];
  $data_fechamento = $_POST['data'];
  
  $sql = $pdo->prepare("UPDATE instalacoes SET status_agendamento='$status_agendamento' , data_fechamento='$data_fechamento' WHERE id_instalacao='$os'");
  $sql->execute();

  $cliente = $pdo->prepare("UPDATE clientes SET status_cliente='ativo' WHERE id_cliente='$id_cliente'");
  $cliente->execute();
  
  echo "<script>location.href='?pg=clientes-by-tecnicos-today'</script>"; 
 } ?>

<?php if (isset($_GET['resolucao'])){

$motivo =  $_POST['motivo'];
$os = $_POST['os'];
$id_cliente = $_POST['id_cliente'];

$sql = $pdo->prepare("UPDATE instalacoes SET status_agendamento='$motivo' WHERE id_instalacao='$os'");
$sql->execute();

$cliente = $pdo->prepare("UPDATE clientes SET status_cliente='$motivo' WHERE id_cliente='$id_cliente'");
$cliente->execute();

echo "<script>location.href='?pg=clientes-by-tecnicos-today'</script>"; 
} ?>

<?php if (isset($_GET['transferencia'])){

$id_tecnico =  $_POST['id_tecnico'];
$os = $_POST['os'];
$id_usuario = $_COOKIE['idusuario'];
$sql = $pdo->prepare("UPDATE instalacoes SET fk_id_tecnico='$id_tecnico', fk_id_usuario='$id_usuario' WHERE id_instalacao='$os'");
$sql->execute();
echo "<script>location.href='?pg=clientes-by-tecnicos-today'</script>"; 
} ?>

<?php if (isset($_GET['reagendar'])){

$os = $_POST['os'];
$data_agendamento = $_POST['data_agendamento'];
$id_usuario = $_COOKIE['idusuario'];
$sql = $pdo->prepare("UPDATE instalacoes SET data_agendamento='$data_agendamento', fk_id_usuario='$id_usuario' WHERE id_instalacao='$os'");
$sql->execute();
echo "<script>location.href='?pg=clientes-by-tecnicos-today'</script>"; 
} ?>

<?php 
if (isset($_GET['iclass'])){

    $data = $_GET['data'];
    $os = $_GET['os'];

    $ossql = $pdo->prepare("UPDATE instalacoes SET status_iclass='1' where id_instalacao='$os' ");
    $ossql->execute();
   

    echo "<script>location.href='?pg=clientes-by-tecnicos-today'</script>"; 
}
?>

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