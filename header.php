<header id="main-header">
  <div class="navbar">
    <div class="logo">Ocenjevanje</div>
    <nav>
      <ul>
        <li><a href="main.php">Domov</a></li>
        <li><a href="teachers.php">Učitelji</a></li>
        <li><a href="logout.php">Odjava</a></li>
      </ul>
    </nav>
  </div>
</header>

<style>
  header {
    width: 100%;
    background-color: #4c51bf;
    color: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: top 0.4s;
  }

  .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    max-width: 1200px;
    margin: 0 auto;
  }

  .logo {
    font-size: 1.5rem;
    font-weight: bold;
  }

  nav ul {
    display: flex;
    gap: 1.5rem;
    list-style: none;
  }

  nav a {
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: color 0.3s;
  }

  nav a:hover {
    color: #c3dafe;
  }

  body {
    padding-top: 80px; /* prostor za header */
  }
</style>

<script>
  let lastScrollTop = 0;
  const header = document.getElementById("main-header");

  window.addEventListener("scroll", function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
      // Scroll down -> hide header
      header.style.top = "-80px";
    } else {
      // Scroll up -> show header
      header.style.top = "0";
    }
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
  });
</script>
