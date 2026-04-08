<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arviu.net</title>
  <link rel="icon" type="image/png" href="assets/images/arviu-logo.ico">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/blog.css">

</head>

<body>

  <div id="navbar"></div>
  <header class="header">
    <h1>01: Creating my own website</h1>
    <p></p>
  </header>

  <main class="main-content">
    <section>
      <p class="date">08/04/2026</p>
      <h1 id="my-goal">My goal</h1>
      <br>
      <p>Trying to organize my thoughts better, I came up with the idea of creating some kind of knowledge base
        documenting projects and things I learned. I thought it would be a fun and at the same time very useful idea to
        also share my learnings online while also recording my progress and building a portfolio and personal
        presentation website.</p>

      <br>
      <h1 id="first-steps">First Steps</h1>
      <br />
      <p>As someone who&#39;s very interested in all things IT and fiddling around with a home server all the time,
        selfhosting the website was a no-brainer. Also my goal is to setup the container and web stack manually to
        really understand how everything works. I&#39;ve looked at easier all-in-one solutions like WordPress, but
        decided against using it because of the aforementioned reason.</p>
      <br>

      <h2 id="techstack">Techstack</h2>
      <br>
      <ul>
        <li>Proxmox -&gt; Debian LXC Container</li>
        <li>Nginx</li>
        <li>MySQL</li>
        <li>PHP</li>
      </ul>
      <br>
      <p>I decided for PHP over nodejs as I&#39;m currently using php as the preferred backend language in school, same
        for MySQL.</p>
      <br>

      <h3 id="container-creation">Container creation</h3>
      <p>I opted for a standard Debian 12 installation for continued support and updates as well as minimum resources in
        terms of 8 GB of disk space with 1 available core and 514 mib RAM.
        These specs should be more than suitable to start out, increasing container resources is just one click away
        after all.</p>
      <br>
      <h3 id="public-hosting">Public hosting</h3>
      <p>Luckily I already set up a Cloudflared tunnel to access some selfhosted services via my domain. A dedicated
        container runs a Cloudflare tunnel exit with an open route to my selfhosting containers, so adding an extra IP
        and domain pointing to it was done in a few clicks.
        Now Cloudflared acts as a proxy taking in traffic directed to my domain, handles ssl and forwards traffic
        directly towards my container.
        I won&#39;t go over the exact setup of the tunnel here but following the official documentation makes setting
        one up fairly easy (one bash script copy paste lol).</p>
      <br>
      <img src="assets/images/blog 01/cloudflare-tunnel.png">
      <br>
      <h3 id="setting-up-the-web-stack">Setting up the web stack</h3>
      <br>
      <p>After updating the container and all of the packages I installed the nginx package and checked its uptime. To
        manage local firewall rules I configures ufw to allow the nginx service to listen on ports 80 and 443 and
        checked my public url for the first time. ê voilla:</p><br>
      <img src="assets/images/blog 01/welcome-nginx.png">
      <br>
      <p>The php installation wasn&#39;t more than a quick package pull.
        While I won&#39;t use a database right now I tried installing mysql-server right away anyways, but couldn&#39;t
        find the required package. Turns out mysql-server has been discontinued in favor of mariadb, so I used the
        concurrent version of mariadb instead.</p>
      <br>
      <h4 id="setting-up-nginx">Setting up NGINX</h4>
      <br>
      <p>To organize my directories I created a new directory at /var/www/Arviu.net/ and initialized a GitHub repository
        after setting up a basic folder structure consisting of public, src, assets, images, js, css and template
        folders.
        Getting rid of the default &quot;your nginx isn&#39;t set up&quot; landing page I edited the sites-available
        file to point to the root index.php file of my website.
        This led to php errors, which I luckily was able to get rid of quickly since I&#39;ve had a similar problem
        while setting up my nextcloud container: I messed up the path to the php file.
        php-fpm8.2.sock -&gt; php8.2-fpm.sock
        After fixing the appended version placement I was able to run my first &quot;echo &quot;Hello world&quot;&quot;
        on the website!</p><br>
      <img class="config" src="assets/images/blog 01/nginx-config.png">
      <h2 id="github-actions">Github Actions</h2>
      <p>After starting to write some html to setup a basic homepage I realized I had to manually pull the repo inside
        my container every time I wanted to deploy a change. Then I thought &quot;Well brother ain&#39;t no way I&#39;m
        doin that every time.&quot; and went on a quick research spree to automate that shit.
        I came across the concept of CI/CD (continuous integration/continuous deployment) and once again was blown away
        by the fact, that whatever problem you might have: Someone smarter than you already solved it ages ago.
        Considering I use GitHub as my preferred version control I decided for GitHub actions to realize my dream of
        just pressing a button and my container automatically updating.
        Using a script, GitHub is able to setup a container, connect to my website-hosting container via ssh and execute
        the given pull commands.
        Enabling GitHub to do that requires a few things:</p><br>
      <ul>
        <li>ssh access</li>
        <li>ssh private key</li>
        <li>deployment script</li>
      </ul><br>
      <p>Since I kind of actually dislike to port forward from my home router directly I setup routing rules on my cheap
        proxy VPS, which is connected to my homelab network via tailscale (love tailscale btw.) Now the open port on my
        vps points to the ssh port 22 of my hosting container. Since getting random port scanning bots trying to hack my
        shit would be kinda annoying I immedeatly disabled password login in the containers ssh configs and enabled
        public key auth. Just to make sure, I also disabled the root ssh login.
        Then I generated a new key pair and added the private key as well as the IP and port of my VPS as GitHub Actions
        secret repository variables.
        To finish off I yoinked a ready made deployment script to my .github folder, which perfectly worked first try!
        Obviously it didn&#39;t, I first had to fix folder permissions. I created the folder structure and pulled the
        repository as rool, so GitHub complained about another user using git commands in the given directory. Nothing a
        quick delete, relog and repull couldn&#39;t get rid off.</p>
      <br>
      <h2 id="what-i-learned">What I learned</h2>
      <br>
      <ul>
        <li>Rudimentary use of GitHub Actions</li>
        <li>Setting up NGINX</li>
        <li>SSH Key authentication</li>
      </ul>
      <br>
      <h3 id="guides-used-">Guides used:</h3>
      <br>
      <p><a
          href="https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu">https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu</a>
      </p>
      <p><a href="https://youtu.be/YLtlz88zrLg">https://youtu.be/YLtlz88zrLg</a></p>

    </section>
  </main>
  <div id="footer"></div>
  <script type="module" src="assets/js/index.js" defer></script>
</body>

</html>