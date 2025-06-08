<?php 

function headerMenu(){
    echo '
    <body>
    <header class="header bg-warning  py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col text-white">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-truck-fast text-warning"></i>
                        On Delivery
                    </h4>
                </div>
                <div class="col-auto">
                    <nav>
                        <!-- opções para o menu -->
                        <!-- <a href="#" class=" text-decoration-none me-3">Início</a>
                        <a href="#" class=" text-decoration-none me-3">Sobre</a>
                        <a href="#" class=" text-decoration-none">Contato</a> -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main class="main">
    ';
}


function footer(){
    echo '
    </main>
    <footer class="footer text-white bg-warning  py-4 mt-auto">
        <div class="container">
            <hr class="my-3">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0">Trabalho Desenvolvimento de Sistemas - Positivo 2025</p>
                </div>
            </div>
        </div>
    </footer>
    </body>';
}
?>