{{-- <x-page-template bodyClass='error-page'>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
    <x-auth.navbars.navs.guest p='' btn='btn-light' textColor='text-white' svgColor='white'></x-auth.navbars.navs.guest>
  </nav>
  <!-- End Navbar -->
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/uploads/1413399939678471ea070/2c0343f7?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-12 m-auto text-center">
            <h1 class="display-1 text-bolder text-white">Error 419</h1>
            <h2 class="text-white">Page expired</h2>
            <p class="lead text-white">Ooooups! Looks like your token has expired.</p>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
 <x-auth.footers.guest.social-icons-footer></x-auth.footers.guest.social-icons-footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
</x-page-template> --}}






<div class="container">

  <div class="message">

      <figure class="image" style="text-align:center;"><img src="https://pps.org.ph/wp-content/uploads/2021/12/pps-logo.png" style="aspect-ratio: 1/1; width: 204px; height: 204px;"></figure>

      <h1>Reload the page to sign in.</h1>

      <p>Unfortunately, the page you were trying to access has expired due to inactivity. This is a security measure to protect your information.</p>

      <p>Please <strong>refresh the page</strong> and try logging in again.</p>

      <p>

          <button onclick="location.reload();" style="font-size: 20px; padding: 10px 20px;">Refresh Page</button> 

          <button onclick="window.location.href='https://portal.pps.org.ph?ref=' + new Date().getTime();" style="font-size: 20px; padding: 10px 20px;">Go to Login</button>

      </p>

      <p>If you cannot refresh the page, please clear your browser cache.<br><br><strong>Clear Cache in Chrome on iOS:</strong></p>

      <ol style="text-align:left;">

          <li><strong>Open Chrome App:</strong> Launch the Google Chrome app on your iOS device.</li>

          <li><strong>Access Settings:</strong> Tap on the three dots in the bottom right corner to open the menu, then select "Settings."</li>

          <li><strong>Privacy:</strong> Scroll down and tap on "Privacy," then select "Clear Browsing Data."</li>

          <li><strong>Select Data to Clear:</strong> Ensure "Cached Images and Files" is checked. You can uncheck other options if you only want to clear the cache.</li>

          <li><strong>Clear Data:</strong> Tap on "Clear Browsing Data" at the bottom, then confirm by tapping "Clear Browsing Data" again in the pop-up.</li>

          <li><strong>Finish:</strong> Tap "Done" in the top right corner to complete the process.</li>

      </ol>

      <p>This streamlined process will help you quickly clear the cache in Chrome on your iOS device.</p>

  </div>

</div>