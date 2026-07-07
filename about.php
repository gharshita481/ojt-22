<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bellelise & Co. | About Us</title>
  <link rel="icon" href="images/icon2.png">

  <!-- css link -->
   <link rel="stylesheet" href="about.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>

  <div class="responsive-container-block bigContainer">
    <div class="responsive-container-block Container">
      <div class="responsive-container-block leftSide">
        <p class="text-blk heading">About Us</p>
        <p class="text-blk subHeading" style="color:rgb(65, 65, 66);font-size:1em;line-height: 30px;">
        Welcome to Bellelise, where elegance meets craftsmanship in every piece. Our online jewelry store offers a stunning collection of finely crafted jewelry designed to make you feel extraordinary. Whether you're searching for timeless classics, contemporary designs, or something uniquely personal, Bellelise is dedicated to bringing you exquisite pieces that reflect your individual style. Explore our collections and discover the perfect piece that speaks to you.   
        <br><br><b><em>Because at Bellelise, we share a story - yours.</em> </b>
      </p>
      </div>
      <div class="responsive-container-block rightSide">
        <img class="number1img" src="images/a1.jpg" alt="Image 1">
        <img class="number2img" src="images/a2.jpg" alt="Image 2">
        <img class="number3img" src="images/a5.jpg" alt="Image 3">
        <iframe allowfullscreen="allowfullscreen" class="number4vid" poster="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/b242.png" src="abt1.mp4"></iframe>
        <img class="number5img" src="images/a4.jpg" alt="Image 4">
        <img class="number6img" src="images/a3.jpg" alt="Image 5">
        <img class="number7img" src="images/a6.jpg" alt="Image 6">
      </div>
    </div>
  </div>
  
 


<!--TEAM-->

    <style>
        .our-team {
            background: #C5C4C4;
            border: 1px solid #dedede;
            text-align: center;
            color: #8b2635;
            overflow: hidden;
            transition: all 0.3s ease 0s;
            position: relative;
            width: 250px;
            border-radius: 8px;
            margin-left:100px
        }

        .our-team:hover {
          background:rgb(136, 125, 125);
            color: #fff;
        }

        .our-team .pic {
            position: relative;
            overflow: hidden;
        }

        .our-team .pic img {
            width: 100%;
            height: auto;
            transition: all 0.3s ease 0s;
        }

        .our-team:hover .pic img {
            transform: translateY(-20px);
        }

        /* Social Media Icons */
        .our-team .social {
            width: 20%;
            height: 100%;
            background:rgb(136, 125, 125);
            padding: 20px 0;
            margin: 0;
            list-style: none;
            position: absolute;
            top: 0;
            left: -100%; /* Keep the original transition effect */
            transition: all 0.5s ease 0s;
        }

        .our-team:hover .social {
            left: 0; /* Slide in effect */
        }

        .our-team .social li {
            display: block;
        }

        .our-team .social li a {
            display: block;
            padding: 10px 0;
            font-size: 20px;
            color: #fff;
            transition: all 0.5s ease 0s;
        }

        .our-team .social li a:hover {
            color: #ff9b19;
        }

        /* Team Content */
        .our-team .team-content {
            padding: 25px 0;
        }

        .our-team .title {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0 0 10px 0;
        }

        .our-team .post {
            display: block;
            font-size: 15px;
            text-transform: capitalize;
        }

        /* Mobile Responsive */
        @media only screen and (max-width: 990px) {
            .our-team {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>

<div class="container"style="padding-bottom:90px;">
    <h2 style="margin-left:600px; margin-top:100px;"> <u> Meet Our Team</u></h2>
    <div class="row" style="display: flex; justify-content: center; gap: 20px;">
        <div class="our-team">
            <div class="pic">
                <img src="images/pv1.jpg" alt="Williamson">
                <ul class="social">
                    <li><a href="#" class="fab fa-facebook"></a></li>
                    <li><a href="#" class="fab fa-google-plus"></a></li>
                    <li><a href="#" class="fab fa-instagram"></a></li>
                    <li><a href="#" class="fab fa-linkedin"></a></li>
                </ul>
            </div>
            <div class="team-content" >
                <h3 class="title">Priya Vandana</h3>
                <span class="post">Web Developer</span>
            </div>
        </div>
        

        <div class="our-team">
            <div class="pic">
                <img src="images/ca2.jpg" alt="Williamson">
                <ul class="social">
                    <li><a href="#" class="fab fa-facebook"></a></li>
                    <li><a href="#" class="fab fa-google-plus"></a></li>
                    <li><a href="#" class="fab fa-instagram"></a></li>
                    <li><a href="#" class="fab fa-linkedin"></a></li>
                </ul>
            </div>
            <div class="team-content">
                <h3 class="title">Chhata Aditya</h3>
                <span class="post">Web Developer</span>
            </div>
        </div>


        <div class="our-team">
            <div class="pic">
                <img src="images/hg1.jpg" alt="Kristiana">
                <ul class="social">
                    <li><a href="#" class="fab fa-facebook"></a></li>
                    <li><a href="#" class="fab fa-google-plus"></a></li>
                    <li><a href="#" class="fab fa-instagram"></a></li>
                    <li><a href="#" class="fab fa-linkedin"></a></li>
                </ul>
            </div>
            <div class="team-content">
                <h3 class="title">Harshita Gupta</h3>
                <span class="post">Web Designer</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>
