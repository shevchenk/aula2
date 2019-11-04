<style type="text/css">
@font-face {
  font-weight: normal;
  font-style: normal;
}
/* =======================================================
*
*   Template Style 
* Edit this section
*
* ======================================================= */
body {
  font-family: "Roboto", Arial, sans-serif;
  font-weight: 300;
  font-size: 20px;
  line-height: 1.6;
  color: rgba(0, 0, 0, 0.5);
}
@media screen and (max-width: 992px) {
  body {
    font-size: 16px;
  }
}

@media (min-width: 0px) and (max-width: 750px) {
  .formatotexto{
    min-height: 10px;
    margin-bottom: 10px;
    margin-top: 10px;
  }
}

.formatotexto{
  margin-bottom: 15px;
  margin-top:10px;
  font-size: 15px;
  padding: 5px 5px;
  background-color: #F5F5F5;
  border: 3px solid #F8F8F8;
  min-height: 200px;
  border-radius: 20px;
}

.row>.col-lg-3>button{
  border-radius: 20px;
}

.formatotitulo{
  margin-bottom: 15px;
  margin-top:10px;
  font-size: 20px;
  padding: 5px 5px;
  border-radius: 10px;
  text-align: center;
  min-height: 85px;
  display: grid;
  align-items: center;
}

.CabContenido{
  min-height: 650px;
  max-height: 650px;
  overflow-y: auto;
}

.CabContenidoG:hover, .CabContenidoG:focus {
  border: 10px solid #000;
}

a {
  color: #da1212;
  -webkit-transition: 0.5s;
  -o-transition: 0.5s;
  transition: 0.5s;
}
a:hover, a:active, a:focus {
  color: #da1212;
  outline: none;
}

p {
  margin-bottom: 1.5emc}

h1, h2, h3, h4, h5, h6 {
  color: #000;
  font-family: "Montserrat", Arial, sans-serif;
  font-weight: 700;
  margin: 0 0 30px 0;
}

figure {
  margin-bottom: 2.5em;
  float: left;
  width: 100%;
}

::-webkit-selection {
  color: #fff;
  background: #da1212;
}

::-moz-selection {
  color: #fff;
  background: #da1212;
}

::selection {
  color: #fff;
  background: #da1212;
}

#fh5co-page {
  width: 100%;
  overflow: hidden;
  position: relative;
}

#fh5co-aside {
  padding-top: 40px;
  padding-bottom: 40px;
  width: 15%;
  position: fixed;
  bottom: 0;
  top: 0;
  left: 0;
  overflow-y: scroll;
  -webkit-transition: 0.5s;
  -o-transition: 0.5s;
  transition: 0.5s;
}
#fh5co-aside.border {
  border-right: 1px solid #e6e6e6;
}
@media screen and (max-width: 1200px) {
  #fh5co-aside {
    width: 30%;
  }
}
@media screen and (max-width: 768px) {
  #fh5co-aside {
    width: 270px;
    -moz-transform: translateX(-270px);
    -webkit-transform: translateX(-270px);
    -ms-transform: translateX(-270px);
    -o-transform: translateX(-270px);
    transform: translateX(-270px);
  }
}
#fh5co-aside #fh5co-logo {
  text-align: center;
}
#fh5co-aside #fh5co-main-menu ul {
  text-align: center;
  margin: 0;
  padding: 0;
}
@media screen and (max-width: 768px) {
  #fh5co-aside #fh5co-main-menu ul {
    margin: 0 0 2em 0;
  }
}
#fh5co-aside #fh5co-main-menu ul li {
  margin: 0 0 10px 0;
  padding: 0;
  list-style: none;
}
#fh5co-aside #fh5co-main-menu ul li a {
  color: rgba(0, 0, 0, 0.5);
  text-decoration: none;
  letter-spacing: .1em;
  text-transform: uppercase;
  font-size: 15px;
  font-weight: 300;
  position: relative;
  -webkit-transition: 0.3s;
  -o-transition: 0.3s;
  transition: 0.3s;
  padding: 10px 10px;
  letter-spacing: .2em;
  font-family: "Montserrat", Arial, sans-serif;
}
#fh5co-aside #fh5co-main-menu ul li a:after {
  content: "";
  position: absolute;
  height: 2px;
  bottom: 7px;
  left: 10px;
  right: 10px;
  background-color: #da1212;
  visibility: hidden;
  -webkit-transform: scaleX(0);
  -moz-transform: scaleX(0);
  -ms-transform: scaleX(0);
  -o-transform: scaleX(0);
  transform: scaleX(0);
  -webkit-transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  -moz-transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  -ms-transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  -o-transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
#fh5co-aside #fh5co-main-menu ul li a:hover {
  text-decoration: none;
  color: black;
}
#fh5co-aside #fh5co-main-menu ul li a:hover:after {
  visibility: visible;
  -webkit-transform: scaleX(1);
  -moz-transform: scaleX(1);
  -ms-transform: scaleX(1);
  -o-transform: scaleX(1);
  transform: scaleX(1);
}
#fh5co-aside #fh5co-main-menu ul li.fh5co-active a {
  color: black;
}
#fh5co-aside #fh5co-main-menu ul li.fh5co-active a:after {
  visibility: visible;
  -webkit-transform: scaleX(1);
  -moz-transform: scaleX(1);
  -ms-transform: scaleX(1);
  -o-transform: scaleX(1);
  transform: scaleX(1);
}
#fh5co-aside .fh5co-footer {
  position: absolute;
  bottom: 40px;
  font-size: 14px;
  text-align: center;
  width: 100%;
  font-weight: 400;
  color: rgba(0, 0, 0, 0.6);
}
@media screen and (max-width: 768px) {
  #fh5co-aside .fh5co-footer {
    position: relative;
    bottom: 0;
  }
}
#fh5co-aside .fh5co-footer span {
  display: block;
}
#fh5co-aside .fh5co-footer ul {
  padding: 0;
  margin: 0;
  text-align: center;
}
#fh5co-aside .fh5co-footer ul li {
  padding: 0;
  margin: 0;
  display: inline;
  list-style: none;
}
#fh5co-aside .fh5co-footer ul li a {
  color: rgba(0, 0, 0, 0.7);
  padding: 4px;
}
#fh5co-aside .fh5co-footer ul li a:hover, #fh5co-aside .fh5co-footer ul li a:active, #fh5co-aside .fh5co-footer ul li a:focus {
  text-decoration: none;
  outline: none;
  color: #da1212;
}

#fh5co-main {
  width: 85%;
  float: right;
  -webkit-transition: 0.5s;
  -o-transition: 0.5s;
  transition: 0.5s;
}
@media screen and (max-width: 1200px) {
  #fh5co-main {
    width: 70%;
  }
}
@media screen and (max-width: 768px) {
  #fh5co-main {
    width: 100%;
  }
}
#fh5co-main .fh5co-narrow-content {
  position: relative;
  width: 80%;
  margin: 0 auto;
  padding: 4em 0;
}
@media screen and (max-width: 768px) {
  #fh5co-main .fh5co-narrow-content {
    width: 100%;
    padding: 3.5em 1em;
  }
}

body.offcanvas {
  overflow-x: hidden;
}
body.offcanvas #fh5co-aside {
  -moz-transform: translateX(0);
  -webkit-transform: translateX(0);
  -ms-transform: translateX(0);
  -o-transform: translateX(0);
  transform: translateX(0);
  width: 270px;
  background: #fff;
  z-index: 999;
  position: fixed;
}
body.offcanvas #fh5co-main, body.offcanvas .fh5co-nav-toggle {
  top: 0;
  -moz-transform: translateX(270px);
  -webkit-transform: translateX(270px);
  -ms-transform: translateX(270px);
  -o-transform: translateX(270px);
  transform: translateX(270px);
}

.work-item {
  margin-bottom: 30px;
}
.work-item a {
  border: none;
  text-align: center;
}
.work-item a img {
  margin-bottom: 10px;
  float: left;
  border: 10px solid transparent;
  -webkit-transition: 0.5s;
  -o-transition: 0.5s;
  transition: 0.5s;
}
.work-item a h3 {
  font-size: 20px;
  color: #000;
  margin-bottom: 10px;
}
.work-item a p {
  font-size: 14px;
  color: #8B8A97;
  margin-bottom: 0;
}
.work-item a:hover, .work-item a:active, .work-item a:focus {
  text-decoration: none;
}
.work-item a:hover img, .work-item a:active img, .work-item a:focus img {
  border: 10px solid #000;
}

.fh5co-services {
  margin-top: 5px;
}
.fh5co-services ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.work-pagination {
  padding: 3em 0;
}
.work-pagination a {
  color: #000;
}
.work-pagination a:hover {
  color: #da1212;
  text-decoration: none;
}
@media screen and (max-width: 480px) {
  .work-pagination span {
    display: none;
  }
}

.fh5co-border-bottom {
  border-bottom: 1px solid #f0f0f0;
}

.fh5co-testimonial {
  padding: 3em 0;
  background: #da1212;
}
@media screen and (max-width: 768px) {
  .fh5co-testimonial {
    padding: 3em 0;
  }
}
.fh5co-testimonial .item {
  color: white;
  padding-left: 3em;
  padding-right: 3em;
}
@media screen and (max-width: 768px) {
  .fh5co-testimonial .item {
    padding-left: 0em;
    padding-right: 0em;
  }
}
.fh5co-testimonial .item figure {
  text-align: center;
}
.fh5co-testimonial .item figure img {
  max-width: inherit;
  width: 90px;
  margin: 0 auto;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  border-radius: 50%;
}
.fh5co-testimonial .item p {
  font-size: 30px;
}
@media screen and (max-width: 768px) {
  .fh5co-testimonial .item p {
    font-size: 28px;
  }
}
@media screen and (max-width: 480px) {
  .fh5co-testimonial .item p {
    font-size: 20px;
  }
}
.fh5co-testimonial .item .author {
  font-size: 16px;
  display: block;
}

.fh5co-counters {
  padding: 1em 0;
  background: #e6e6e6;
  background-size: cover;
  background-attachment: fixed;
}
.fh5co-counters .fh5co-counter {
  font-size: 50px;
  display: block;
  color: #fff;
  font-family: "Montserrat", Arial, sans-serif;
  width: 100%;
  margin-bottom: .5em;
}
.fh5co-counters .fh5co-counter-label {
  color: #fff;
  text-transform: uppercase;
  font-size: 13px;
  font-family: "Montserrat", Arial, sans-serif;
  letter-spacing: 5px;
  margin-bottom: 2em;
  display: block;
}

.fh5co-lead {
  font-size: 24px;
  line-height: 1.5;
}

.fh5co-heading-colored {
  color: #da1212;
}

.fh5co-cards {
  padding: 1em 0;
  background: #e6e6e6;
}
@media screen and (max-width: 768px) {
  .fh5co-cards {
    padding: 1em 0;
  }
}
.fh5co-cards .fh5co-flex-wrap {
  display: -webkit-box;
  display: -moz-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  flex-wrap: wrap;
  -webkit-flex-wrap: wrap;
  -moz-flex-wrap: wrap;
}
.fh5co-cards .fh5co-flex-wrap > div {
  width: 49.5%;
  margin-right: 1%;
  background: #fff;
  padding: 30px;
  margin-bottom: 10px;
}
.fh5co-cards .fh5co-flex-wrap > div:nth-of-type(1) {
  float: left;
}
.fh5co-cards .fh5co-flex-wrap > div:nth-of-type(2) {
  float: right;
  margin-right: 0%;
}
@media screen and (max-width: 992px) {
  .fh5co-cards .fh5co-flex-wrap > div {
    width: 100%;
    margin-right: 0;
  }
}
.fh5co-cards .fh5co-flex-wrap .fh5co-card p:last-child {
  margin-bottom: 0;
}
.fh5co-cards .fh5co-flex-wrap .fh5co-card h5 {
  text-transform: uppercase;
  font-size: 12px;
  letter-spacing: .2em;
  padding: 4px 8px;
  background: #ebebeb;
  display: -moz-inline-stack;
  display: inline-block;
  zoom: 1;
  *display: inline;
}

.fh5co-counter .fh5co-number {
  font-size: 100px;
  color: #da1212;
  font-weight: 400;
  margin: 0;
  padding: 0;
  line-height: .7;
}
.fh5co-counter .fh5co-number.fh5co-left {
  float: left;
  width: 30%;
}
@media screen and (max-width: 768px) {
  .fh5co-counter .fh5co-number.fh5co-left {
    width: 100%;
    line-height: 1.2;
  }
}
.fh5co-counter .fh5co-text {
  float: right;
  text-align: left;
  width: 70%;
}
@media screen and (max-width: 768px) {
  .fh5co-counter .fh5co-text {
    width: 100%;
    text-align: center;
  }
}
.fh5co-counter .fh5co-text h3 {
  margin: 0;
  padding: 0;
  position: relative;
}
.fh5co-counter .fh5co-text h3.border-bottom:after {
  content: "";
  width: 50px;
}

.fh5co-social {
  padding: 0;
  margin: 0;
  text-align: center;
}
.fh5co-social li {
  padding: 0;
  margin: 0;
  list-style: none;
  display: -moz-inline-stack;
  display: inline-block;
  zoom: 1;
  *display: inline;
}
.fh5co-social li a {
  font-size: 22px;
  color: #000;
  padding: 10px;
  display: -moz-inline-stack;
  display: inline-block;
  zoom: 1;
  *display: inline;
  -webkit-border-radius: 7px;
  -moz-border-radius: 7px;
  -ms-border-radius: 7px;
  border-radius: 7px;
}
@media screen and (max-width: 768px) {
  .fh5co-social li a {
    padding: 10px 8px;
  }
}
.fh5co-social li a:hover {
  color: #da1212;
}
.fh5co-social li a:hover, .fh5co-social li a:active, .fh5co-social li a:focus {
  outline: none;
  text-decoration: none;
  color: #da1212;
}

#map {
  width: 100%;
  height: 700px;
}
@media screen and (max-width: 768px) {
  #map {
    height: 200px;
  }
}

.fh5co-more-contact {
  background: #fafafa;
}

.fh5co-feature {
  text-align: left;
  width: 100%;
  float: left;
  padding: 20px;
}
.fh5co-feature .fh5co-icon {
  float: left;
  width: 10%;
  display: block;
  margin-top: 5px;
}
.fh5co-feature .fh5co-icon i {
  color: #da1212;
  font-size: 70px;
}
@media screen and (max-width: 1200px) {
  .fh5co-feature .fh5co-icon i {
    font-size: 40px;
  }
}
.fh5co-feature.fh5co-feature-sm .fh5co-icon i {
  color: #da1212;
  font-size: 28px;
}
@media screen and (max-width: 1200px) {
  .fh5co-feature.fh5co-feature-sm .fh5co-icon i {
    font-size: 28px;
  }
}
.fh5co-feature .fh5co-text {
  float: right;
  width: 80%;
}
@media screen and (max-width: 768px) {
  .fh5co-feature .fh5co-text {
    width: 82%;
  }
}
@media screen and (max-width: 480px) {
  .fh5co-feature .fh5co-text {
    width: 72%;
  }
}
.fh5co-feature .fh5co-text h2, .fh5co-feature .fh5co-text h3 {
  margin: 0;
  padding: 0;
}
.fh5co-feature .fh5co-text h3 {
  font-weight: 300;
  margin-bottom: 20px;
  color: rgba(0, 0, 0, 0.8);
  font-size: 14px;
  letter-spacing: .2em;
  text-transform: uppercase;
}

.fh5co-heading {
  font-size: 45px;
  margin-bottom: 1em;
}
.fh5co-heading.fh5co-light {
  color: #fff;
}
.fh5co-heading span {
  display: block;
}
@media screen and (max-width: 768px) {
  .fh5co-heading {
    font-size: 30px;
    margin-bottom: 1em;
  }
}

.fh5co-staff img {
  margin-bottom: 1em;
}
.fh5co-staff h3 {
  margin: 0;
}
.fh5co-staff h4 {
  margin: 0 0 20px 0;
  font-weight: 300;
  color: rgba(0, 0, 0, 0.4);
}

.chart {
  width: 160px;
  height: 160px;
  margin: 0 auto 30px auto;
  position: relative;
  text-align: center;
}
.chart span {
  position: absolute;
  top: 50%;
  left: 0;
  margin-top: -30px;
  width: 100%;
}
.chart span strong {
  display: block;
}
.chart canvas {
  position: absolute;
  left: 0;
  top: 0;
}

/* Owl Override Style */
.owl-carousel .owl-controls,
.owl-carousel-posts .owl-controls {
  margin-top: 0;
}

.owl-carousel .owl-controls .owl-nav .owl-next,
.owl-carousel .owl-controls .owl-nav .owl-prev,
.owl-carousel-posts .owl-controls .owl-nav .owl-next,
.owl-carousel-posts .owl-controls .owl-nav .owl-prev {
  top: 50%;
  margin-top: -29px;
  z-index: 9999;
  position: absolute;
  -webkit-transition: 0.2s;
  -o-transition: 0.2s;
  transition: 0.2s;
}

.owl-carousel-posts .owl-controls .owl-nav .owl-next,
.owl-carousel-posts .owl-controls .owl-nav .owl-prev {
  top: 24%;
}

.owl-carousel .owl-controls .owl-nav .owl-next,
.owl-carousel-posts .owl-controls .owl-nav .owl-next {
  right: -40px;
}
.owl-carousel .owl-controls .owl-nav .owl-next:hover,
.owl-carousel-posts .owl-controls .owl-nav .owl-next:hover {
  margin-right: -10px;
}

.owl-carousel .owl-controls .owl-nav .owl-prev,
.owl-carousel-posts .owl-controls .owl-nav .owl-prev {
  left: -40px;
}
.owl-carousel .owl-controls .owl-nav .owl-prev:hover,
.owl-carousel-posts .owl-controls .owl-nav .owl-prev:hover {
  margin-left: -10px;
}

.owl-carousel-posts .owl-controls .owl-nav .owl-next {
  right: -50px;
}
@media screen and (max-width: 768px) {
  .owl-carousel-posts .owl-controls .owl-nav .owl-next {
    right: 0px;
  }
}

.owl-carousel-posts .owl-controls .owl-nav .owl-prev {
  left: -50px;
}
@media screen and (max-width: 768px) {
  .owl-carousel-posts .owl-controls .owl-nav .owl-prev {
    left: 0px;
  }
}

.owl-carousel-posts .owl-controls .owl-nav .owl-next i,
.owl-carousel-posts .owl-controls .owl-nav .owl-prev i,
.owl-carousel-fullwidth .owl-controls .owl-nav .owl-next i,
.owl-carousel-fullwidth .owl-controls .owl-nav .owl-prev i {
  color: #444;
}
.owl-carousel-posts .owl-controls .owl-nav .owl-next:hover i,
.owl-carousel-posts .owl-controls .owl-nav .owl-prev:hover i,
.owl-carousel-fullwidth .owl-controls .owl-nav .owl-next:hover i,
.owl-carousel-fullwidth .owl-controls .owl-nav .owl-prev:hover i {
  color: #000;
}

.owl-carousel-fullwidth.fh5co-light-arrow .owl-controls .owl-nav .owl-next i,
.owl-carousel-fullwidth.fh5co-light-arrow .owl-controls .owl-nav .owl-prev i {
  color: #fff;
}
.owl-carousel-fullwidth.fh5co-light-arrow .owl-controls .owl-nav .owl-next:hover i,
.owl-carousel-fullwidth.fh5co-light-arrow .owl-controls .owl-nav .owl-prev:hover i {
  color: #fff;
}

@media screen and (max-width: 768px) {
  .owl-theme .owl-controls .owl-nav {
    display: none;
  }
}

.owl-theme .owl-controls .owl-nav [class*="owl-"] {
  background: none !important;
}
.owl-theme .owl-controls .owl-nav [class*="owl-"] i {
  font-size: 30px;
}
.owl-theme .owl-controls .owl-nav [class*="owl-"] i:hover, .owl-theme .owl-controls .owl-nav [class*="owl-"] i:focus {
  background: none !important;
}
.owl-theme .owl-controls .owl-nav [class*="owl-"]:hover, .owl-theme .owl-controls .owl-nav [class*="owl-"]:focus {
  background: none !important;
}

.owl-theme .owl-dots {
  position: absolute;
  bottom: 0;
  width: 100%;
  text-align: center;
}

.owl-carousel-fullwidth.owl-theme .owl-dots {
  bottom: 0;
  margin-bottom: -2.5em;
}

.owl-theme .owl-dots .owl-dot span {
  width: 10px;
  height: 10px;
  background: #fff;
  -webkit-transition: 0.2s;
  -o-transition: 0.2s;
  transition: 0.2s;
  border: 3px solid transparent;
}
.owl-theme .owl-dots .owl-dot span:hover {
  background: none;
  border: 3px solid #da1212;
}

.owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
  background: transparent;
  height: 10px;
  border: 2px solid #fff;
}

.btn {
  margin-right: 4px;
  margin-bottom: 4px;
  font-family: "Roboto", Arial, sans-serif;
  font-size: 18px;
  font-weight: 400;
  -webkit-border-radius: 0px;
  -moz-border-radius: 0px;
  -ms-border-radius: 0px;
  border-radius: 0px;
  -webkit-transition: 0.5s;
  -o-transition: 0.5s;
  transition: 0.5s;
  padding: 8px 20px !important;
}
.btn.btn-sm {
  padding: 4px 15px !important;
}
.btn.btn-md {
  padding: 8px 20px !important;
}
.btn.btn-lg {
  padding: 18px 36px !important;
}
.btn:hover, .btn:active, .btn:focus {
  box-shadow: none !important;
  outline: none !important;
}

/*
.btn-primary:hover, .btn-primary:focus, .btn-primary:active {
  background: #ec1919 !important;
  border-color: #ec1919 !important;
}
.btn-primary.btn-outline {
  background: transparent;
  color: #da1212;
  border: 2px solid #da1212;
}
.btn-primary.btn-outline:hover, .btn-primary.btn-outline:focus, .btn-primary.btn-outline:active {
  background: #da1212;
  color: #fff;
}

.btn-success {
  background: #5cb85c;
  color: #fff;
  border: 2px solid #5cb85c;
}
.btn-success:hover, .btn-success:focus, .btn-success:active {
  background: #4cae4c !important;
  border-color: #4cae4c !important;
}
.btn-success.btn-outline {
  background: transparent;
  color: #5cb85c;
  border: 2px solid #5cb85c;
}
.btn-success.btn-outline:hover, .btn-success.btn-outline:focus, .btn-success.btn-outline:active {
  background: #5cb85c;
  color: #fff;
}

.btn-info {
  background: #5bc0de;
  color: #fff;
  border: 2px solid #5bc0de;
}
.btn-info:hover, .btn-info:focus, .btn-info:active {
  background: #46b8da !important;
  border-color: #46b8da !important;
}
.btn-info.btn-outline {
  background: transparent;
  color: #5bc0de;
  border: 2px solid #5bc0de;
}
.btn-info.btn-outline:hover, .btn-info.btn-outline:focus, .btn-info.btn-outline:active {
  background: #5bc0de;
  color: #fff;
}

.btn-warning {
  background: #f0ad4e;
  color: #fff;
  border: 2px solid #f0ad4e;
}
.btn-warning:hover, .btn-warning:focus, .btn-warning:active {
  background: #eea236 !important;
  border-color: #eea236 !important;
}
.btn-warning.btn-outline {
  background: transparent;
  color: #f0ad4e;
  border: 2px solid #f0ad4e;
}
.btn-warning.btn-outline:hover, .btn-warning.btn-outline:focus, .btn-warning.btn-outline:active {
  background: #f0ad4e;
  color: #fff;
}

.btn-danger {
  background: #d9534f;
  color: #fff;
  border: 2px solid #d9534f;
}
.btn-danger:hover, .btn-danger:focus, .btn-danger:active {
  background: #d43f3a !important;
  border-color: #d43f3a !important;
}
.btn-danger.btn-outline {
  background: transparent;
  color: #d9534f;
  border: 2px solid #d9534f;
}
.btn-danger.btn-outline:hover, .btn-danger.btn-outline:focus, .btn-danger.btn-outline:active {
  background: #d9534f;
  color: #fff;
}

.btn-outline {
  background: none;
  border: 2px solid gray;
  font-size: 16px;
  -webkit-transition: 0.3s;
  -o-transition: 0.3s;
  transition: 0.3s;
}
.btn-outline:hover, .btn-outline:focus, .btn-outline:active {
  box-shadow: none;
}
*/
.form-control {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  box-shadow: none;
  background: transparent;
  border: 2px solid rgba(0, 0, 0, 0.1);
  height: 54px;
  font-size: 18px;
  font-weight: 300;
  -webkit-border-radius: 0px;
  -moz-border-radius: 0px;
  -ms-border-radius: 0px;
  border-radius: 0px;
}
.form-control:active, .form-control:focus {
  outline: none;
  box-shadow: none;
  border-color: #da1212;
}

#message {
  height: 130px;
}

.fh5co-nav-toggle {
  cursor: pointer;
  text-decoration: none;
}
.fh5co-nav-toggle.active i::before, .fh5co-nav-toggle.active i::after {
  background: #000;
}
.fh5co-nav-toggle.dark.active i::before, .fh5co-nav-toggle.dark.active i::after {
  background: #000;
}
.fh5co-nav-toggle:hover, .fh5co-nav-toggle:focus, .fh5co-nav-toggle:active {
  outline: none;
  border-bottom: none !important;
}
.fh5co-nav-toggle i {
  position: relative;
  display: -moz-inline-stack;
  display: inline-block;
  zoom: 1;
  *display: inline;
  width: 30px;
  height: 2px;
  color: #000;
  font: bold 14px/.4 Helvetica;
  text-transform: uppercase;
  text-indent: -55px;
  background: #000;
  transition: all .2s ease-out;
}
.fh5co-nav-toggle i::before, .fh5co-nav-toggle i::after {
  content: '';
  width: 30px;
  height: 2px;
  background: #000;
  position: absolute;
  left: 0;
  -webkit-transition: 0.2s;
  -o-transition: 0.2s;
  transition: 0.2s;
}
.fh5co-nav-toggle.dark i {
  position: relative;
  color: #000;
  background: #000;
  transition: all .2s ease-out;
}
.fh5co-nav-toggle.dark i::before, .fh5co-nav-toggle.dark i::after {
  background: #000;
  -webkit-transition: 0.2s;
  -o-transition: 0.2s;
  transition: 0.2s;
}

.fh5co-nav-toggle i::before {
  top: -7px;
}

.fh5co-nav-toggle i::after {
  bottom: -7px;
}

.fh5co-nav-toggle:hover i::before {
  top: -10px;
}

.fh5co-nav-toggle:hover i::after {
  bottom: -10px;
}

.fh5co-nav-toggle.active i {
  background: transparent;
}

.fh5co-nav-toggle.active i::before {
  top: 0;
  -webkit-transform: rotateZ(45deg);
  -moz-transform: rotateZ(45deg);
  -ms-transform: rotateZ(45deg);
  -o-transform: rotateZ(45deg);
  transform: rotateZ(45deg);
}

.fh5co-nav-toggle.active i::after {
  bottom: 0;
  -webkit-transform: rotateZ(-45deg);
  -moz-transform: rotateZ(-45deg);
  -ms-transform: rotateZ(-45deg);
  -o-transform: rotateZ(-45deg);
  transform: rotateZ(-45deg);
}

.fh5co-nav-toggle {
  position: fixed;
  left: 0;
  top: 0px;
  z-index: 9999;
  cursor: pointer;
  opacity: 1;
  visibility: hidden;
  padding: 20px;
  -webkit-transition: 0.5s;
  -o-transition: 0.5s;
  transition: 0.5s;
}
@media screen and (max-width: 768px) {
  .fh5co-nav-toggle {
    opacity: 1;
    visibility: visible;
  }
}

@media screen and (max-width: 480px) {
  .col-xxs-12 {
    float: none;
    width: 100%;
  }
}

.row-bottom-padded-lg {
  padding-bottom: 7em;
}
@media screen and (max-width: 768px) {
  .row-bottom-padded-lg {
    padding-bottom: 1em;
  }
}

.row-bottom-padded-md {
  padding-bottom: 4em;
}
@media screen and (max-width: 768px) {
  .row-bottom-padded-md {
    padding-bottom: 1em;
  }
}

.row-bottom-padded-sm {
  padding-bottom: 1em;
}
@media screen and (max-width: 768px) {
  .row-bottom-padded-sm {
    padding-bottom: 1em;
  }
}

.js .animate-box {
  opacity: 0;
}
/*# sourceMappingURL=style.css.map */
</style>
