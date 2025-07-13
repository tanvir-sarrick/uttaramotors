
<head>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arvo'>
    <style>
        .page_404 {
            padding:40px 0;
            background:#fff;
            font-family: 'Arvo', serif;
        }

        .page_404  img {
            width:100%;
        }

        .four_zero_four_bg {
            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 400px;
            background-position: center;
        }

        .four_zero_four_bg h1 {
            font-size:80px;
        }

        .four_zero_four_bg h3{
            font-size:80px;
        }

        .link_404{
            cursor: pointer;
            color: #fff!important;
            padding: 10px 20px;
            background: linear-gradient(270deg, rgba(115, 103, 240, 0.7) 0%, rgb(115, 103, 240) 100%);;
            margin: 20px 0;
            display: inline-block;
            border-radius: 10px;

        }
        a {
            text-decoration: none!important;
        }

        a:hover {
            color:#000!important;
            font-weight: 700;
        }
        .contant_box_404 {
            margin-top:-50px;
        }
    </style>
</head>

  <body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center ">500</h1>
                        </div>

                        <div class="contant_box_404">
                            <<h3 class="h2" style="color: red; font-weight: 700;">
                                Oops! Internal Server Error
                            </h3>
                            <p>Something went wrong on our end. Please try again later.</p>

                            <a href="{{ route('dashboard.home.index') }}" class="link_404">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </body>
