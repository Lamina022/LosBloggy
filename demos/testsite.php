<!DOCTYPE html>
<html>
<head>
<title>Homepage</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
  font-family: Arial, "Lato", sans-serif;
  margin: 0;
  padding: 0;
}

ul {
  list-style: none;
  padding-left: 0;
}

/* Style the body */
body {
  margin: 0;
  display: flex;
  min-height: 100vh;
  flex-direction: column;
}

.container {
    flex: 1;    /* same as flex-grow: 1; */
}

/* Header/logo Title */
.header {
  padding: 90px;
  text-align: center;
  background: #555;
  color: white;
}

/* Style the top navigation bar */
.navbar {
  display: flex;
  background-color: #333;
}

/* Style the navigation bar links */
.navbar a {
  color: orange;
  padding: 14px 20px;
  text-decoration: none;
  text-align: center;
}

/* Change color on hover */
.navbar a:hover {
  background-color: #777;
  color: white;
  text-decoration: none;
}

/* ----- Footer ------ */

/* Generic styling */
footer {
  background-color: #555;
  color: #bbb;
  line-height: 1.5;
}

footer a {
  text-decoration: none;
  color: #eee;
}

a:hover {
  text-decoration: underline;
}

.ft-title {
  color: #fff;
  font-family: "Merriweather", serif;
  font-size: 1.375rem;
  padding-bottom: 0.625rem;
}

/* Sticks footer to bottom */
body {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
}

/* Footer main */
.ft-main {
  padding: 1.25rem 1.875rem;
  display: flex;
  flex-wrap: wrap;
}

@media only screen and (min-width: 29.8125rem /* 477px */) {
  .ft-main {
    justify-content: space-evenly;
  }
}

@media only screen and (min-width: 77.5rem /* 1240px */) {
  .ft-main {
    justify-content: space-evenly;
  }
}

.ft-main-item {
  padding: 1.25rem;
  min-width: 12.5rem;
}


/* Footer main | Newsletter form */
form {
  display: flex;
  flex-wrap: wrap;
}

input[type="email"] {
  border: 0;
  padding: 0.625rem;
  margin-top: 0.3125rem;
}

input[type="submit"] {
  background-color: #00d188;
  color: #fff;
  cursor: pointer;
  border: 0;
  padding: 0.625rem 0.9375rem;
  margin-top: 0.3125rem;
}

/* Footer social */
.ft-social {
  padding: 0 1.875rem 1.25rem;
}

.ft-social-list {
  display: flex;
  justify-content: center;
  border-top: 1px #777 solid;
  padding-top: 1.25rem;
}

.ft-social-list li {
  margin: 0.5rem;
  font-size: 1.25rem;
}

/* Footer legal */
.ft-legal {
  padding: 0.9375rem 1.875rem;
  background-color: #333;
}

.ft-legal-list {
  width: 100%;
  display: flex;
  flex-wrap: wrap;
}

.ft-legal-list li {
  margin: 0.125rem 0.625rem;
  white-space: nowrap;
}

/* one before the last child */
.ft-legal-list li:nth-last-child(2) {
    flex: 1;
}
</style>
</head>
<body>
<!-- Header -->
<div class="header">
  <h1>Welcome to proj-wul.ch</h1>
  <p>A project from Lisa Wuethrich</p>
</div>

<!-- Navigation Bar -->
<div class="navbar">
  <a href="#">Link</a>
  <a href="#">Link</a>
  <a href="#">Link</a>
  <a href="#">Link</a>
</div>

<!-- Footer -->
<div class="container"></div>
    <footer>
      <!-- Footer social -->
      <section class="ft-social">
        <ul class="ft-social-list">
          <li><p>Read. Write. Evolve.</p></li>
        </ul>
      </section>
      
      <!-- Footer main -->
      <section class="ft-main">
        <div class="ft-main-item">
          <h2 class="ft-title">About</h2>
          <ul>
            <li><a href="#">About this Project</a></li>
            <li><a href="#">Portfolio</a></li>
            <li><a href="#">Sitemap</a></li>
            <li><a href="#"></a></li>
            <li><a href="#"></a></li>
          </ul>
        </div>
        <div class="ft-main-item">
          <h2 class="ft-title">Contact</h2>
          <ul>
            <li><a href="#">Contact us</a></li>
            <li><a href="https://webcoders.ch">Webcoders.ch</a></li>
            <li><a href="#"></a></li>
          </ul>
        </div>
        <div class="ft-main-item">
          <h2 class="ft-title"></h2>
          <ul>
            <li></li>
          </ul>
        </div>
        <div class="ft-main-item">
          <h2 class="ft-title">Get Started</h2>
          <p>Start writing your blog today and expense your knowledge even further.</p>
          <form>
            <input type="email" name="email" placeholder="Enter email address">
            <input type="submit" value="Sign Up">
          </form>
        </div>
      </section>
    
      <!-- Footer legal -->
      <section class="ft-legal">
        <ul class="ft-legal-list">
          <li><a href="#">Terms &amp; Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li>&copy; 2020 Wuethrich Lisa</li>
        </ul>
      </section>
    </footer>
  </body>
</html>
