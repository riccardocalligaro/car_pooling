<?php

function cp_head($page_name, $dir_prefix)
{ 
   echo '<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="preconnect" href="https://fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,700;1,400&display=swap"
       rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
       integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
       crossorigin="anonymous"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
       integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
   <link rel="stylesheet" href="'.$dir_prefix.'css/style.css">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="'.$dir_prefix.'js/main.js"></script>

   <title>'.$page_name.'</title>
</head>';
} 


function cp_failure() {
    echo '<div class="text-center pt-5 pb-5">
        <i class="fas fa-ticket-alt fa-3x"></i>
        <h1>Errore</h1>
        <p>Riprova più tardi</p>
        </div>';
}


function cp_success() {
    echo '<div class="text-center pt-5 pb-5">
    <i class="fas fa-ticket-alt fa-3x"></i>
    <h1>Successo</h1>
    </div>';
}




function cp_authenitcated_nav()
{ 
   echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">
   <div class="container-fluid">
       <a class="navbar-brand" href="index.html">CarPooling</a>
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
           data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
           aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="#">Home</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#">Link</a>
               </li>
               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                       Dropdown
                   </a>
                   <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                       <li><a class="dropdown-item" href="#">Action</a></li>
                       <li><a class="dropdown-item" href="#">Another action</a></li>
                       <li>
                           <hr class="dropdown-divider">
                       </li>
                       <li><a class="dropdown-item" href="#">Something else here</a></li>
                   </ul>
               </li>
           </ul>
       </div>
   </div>
   </nav>
   ';
} 
