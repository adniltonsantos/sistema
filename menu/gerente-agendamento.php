
<?php 

$sqlTransf = $pdo->prepare("SELECT * FROM instalacoes where tipo_instalacao='transfres' AND tipo_instalacao='transfcond' OR status_agendamento='agendar'");
$sqlTransf->execute();

$sqlHack = $pdo->prepare("SELECT * FROM clientes where status_cliente='aguardando-instalacaoHack'");
$sqlHack->execute();

?>

<?php if($setor == 'adm/agendamento'){ ?>
   <nav id="menu">
        <ul>
        <li><a href='?pg=agendamento-dashboard'>DashBoard</a></li>
         <li><a href='#'>Clientes</a>
                <ul class="dropdown-sub"> 
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-pesquisa">Por COD</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-pesquisa-ref">Por REF</a></li>
                    <!-- <li class="dropdown-sub-menu"><a href="?pg=clientes-referencia">Por REF</a></li> -->
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-correcao">Correção</a></li>
                </ul> 
            </li>
            <li><a href='?pg=clientes-agendar'>Agendar</a></li>
          
            <li><a href='#'>Agendados</a>
            <ul class="dropdown-sub"> 
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-by-agendamento&data=<?php echo $data = date('Y-m-d')?>">Residencia</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-by-agendamento2&data=<?php echo $data = date('Y-m-d')?>">Condominio</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-by-tecnicos-today">Hoje</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-by-tecnicos-all&between&data=<?php echo date('Y-m-d')?>&data2=<?php echo date('Y-m-d')?>">Geral</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-by-tecnicos-by&between&data=<?php echo date('Y-m-d')?>&data2=<?php echo date('Y-m-d')?>">Por Técnico</a></li>
                 </ul> 
            </li>

            <li><a href='#'>Problemas</a>
                <ul class="dropdown-sub"> 
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-cto">CTO</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-cancelou">CANCELOU</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-indis">INDISPONIBILIDADE</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-infra">INFRAESTRUTURA</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-reagendar">REAGENDAR</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-rede">REDE</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-rc">RETORNO DE CLIENTE</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-whats">AGUARDANDO WHATS</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-sem-contato">SEM CONTATO</a></li>
                 </ul> 
            </li>
            <li><a href='?pg=producao-terceiros'>Produção Terceiros</a></li>         
          
          
            <li><a href='?pg=clientes-transferencias'>Transferencia <span class="badge badge-primary" style="float:right; margin-right:10px;background-color:red"><?php echo $total = $sqlTransf->rowCount(); ?></span></a></li>  
            <li><a href='?pg=clientes-hack'>HACK <span class="badge badge-primary" style="float:right; margin-right:10px;background-color:red"><?php echo $total = $sqlHack->rowCount(); ?></span></a></li>          
                    
            <li><a href=''>Concluidos</a>
            <ul class="dropdown-sub"> 
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-concluido-today">Hoje</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-concluido-all">Geral</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=clientes-concluido-tecnico">Por Técnico</a></li>
                 </ul> 
            </li>
            <li><a href='#'>Importar</a>
            <ul class="dropdown-sub"> 
                    <li class="dropdown-sub-menu"><a href="?pg=import-xls">CSV</a></li>
                    <li class="dropdown-sub-menu"><a href="?pg=import-validar">Inconsistências</a></li> 
                </ul>   
            </li>
         </ul>

         
   </nav>
<?php } ?>

