<?php
echo '			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Painel</a>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li class="active"><a href="home.php">Home</a></li>
                            <li><a href="cadastro_maq.php">Máquina</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Serviços <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="ftp.php">FTP</a></li>
									<li><a href="dhcp.php">DHCP</a></li>
									<li><a href="csamba.php">Samba</a></li>
								</ul>
							</li>
                            <li><a href="configurados.php">Configurados</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#" data-target="#pwdModal" data-toggle="modal">Ajuda</a></li>
							<li><a href="perfil.php">Perfil</a></li>
							<li><a href="index.php?func=logout"><span class="glyphicon glyphicon-off"></span> Logout </a></li>
						</ul>
					</div>
				</div>
			</nav>
			<!--MODAL AJUDA-->
			<div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<img src="images/ajuda.png" class="img-responsive">
                    </div>
                </div>
            </div>';
?>