<style>
    footer{
        background: #1b1e21;
        width: 100%;    
        padding: 1px;    
        position: fixed;
        bottom:0;       
        font-size: 10px;   
        z-index: 100;  
         
    }
    footer p{           
        text-align: center;         
    }
    #contact-icons i.fas, #contact-icons i.fab {
        color: #000; 
        font-size: 20px;
        margin-right: 10px; 
    }
    #contact-icons a {
        color: #000;
        text-decoration: none;
    }
    #contact-icons a:hover {
        color: #007bff; 
    }
    .modal-body p {
        line-height: 1.8; 
    }
    .text-muted {
        font-size: 14px;
        margin-top: 15px;
    }    
</style>
<!-- -------------------------------- -->
<footer class="bg-dark text-white text-center">  
<!-- &copy;   -->
    2024 Creado por 
    <a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#creatorsModal">
        Maxi
    </a>
</footer>
<!---------- Creators Modal ----------->
<div class="modal fade" id="creatorsModal" tabindex="-1" aria-labelledby="creatorsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">                
                <h5 class="modal-title" id="creatorsModalLabel">
                    Creado por Maximiliano Olmos 
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                
                <div id="contact-icons" class="text-left">
                    <p>
                        <i class="fas fa-envelope"></i>maxiolmos1993@gmail.com<br>                        
                    </p>
                </div>                
                <p class="text-muted text-left py-0 my-0">
                    ¡Contáctanos para más información sobre nuestros proyectos!
                </p>
            </div>   
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- ----------- -->
</body>
</html>