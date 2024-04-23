<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login</title>
</head>
<body class="bg-gray-100 w-full">
  <section class="min-h-screen flex flex-col items-center justify-center">
    <div class="z-50 bg-gray-100 flex flex-col sm:flex-row rounded-2xl shadow-lg max-w-3xl p-5">
      <div class="sm:w-1/2 sm:block hidden ">
        <img class="h-full rounded-2xl" src="../../assets/bed.jpg" alt="">
      </div>
      <div class="w-full sm:w-1/2 pl-7 pr-7">
        <h2 class="font-bold text-black text-2xl font-sans">Welcome Back</h2>
        <p class="text-[#63B3A8] mt-1 font-sans">Login your account</p>
        <form class="flex flex-col gap-2" form action="{{ route('login') }}" method="post">
          @csrf
          <div class="flex flex-col sm:flex-row w-[330px] bg-[#DCDCDC] mt-3 rounded-lg gap-2">
            <input
              class="bg-[#DCDCDC] p-2 ml-7 border-l-2 border-l-[#DCDCDC] rounded-lg text-black font-sans sm:w-[304px]"
              type="email" name="email" id="email" placeholder="Email" required>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-envelope absolute translate-x-2 translate-y-3 " viewBox="0 0 16 16">
              <path
                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
            </svg> 
          </div>
          <div class="flex flex-col sm:flex-row w-[330px] bg-[#DCDCDC] rounded-lg gap-2">
            <input
              class="bg-[#DCDCDC] p-2 ml-6 border-l-2 border-l-[#DCDCDC] rounded-lg text-black font-sans sm:w-[304px]"
              type="password" name="password" id="password" placeholder="Password" required>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-key absolute translate-x-2 translate-y-3" viewBox="0 0 16 16">
              <path
                d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
              <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
            </svg>
          </div>
          <div id="checkPassword" class="font-blod text-[#B22222] mt-2 font-sans">Wrong pasword. Please try again.</div>
          <div class="mt-3 flex justify-between items-center">
            <div>
              <input type="checkbox" name="remember me" id="rememberme">
              <label for="" class="font-sans">Remember me</label>
            </div>
            <div>
              <a href="{{ route('password.request') }}" class="text-black font-sans">Forgot Password</a>
            </div>
          </div>
          <button class="bg-[#63B3A8] text-white p-2 rounded-md font-sans">Login</button>
        </form>
        <br>
        <a href="{{ route('google.redirect') }}" class="bg-white text-black p-2 rounded-md font-sans flex items-center justify-center mx-auto shadow-md">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="remix-icon">
                    <path
                        d="M3.28826 8.39085L2.82415 10.1235L1.12782 10.1593C0.620865 9.21906 0.333313 8.14325 0.333313 7.00002C0.333313 5.89453 0.602167 4.85202 1.07873 3.93408H1.07909L2.5893 4.21096L3.25086 5.7121C3.1124 6.11578 3.03693 6.54911 3.03693 7.00002C3.03698 7.4894 3.12563 7.95828 3.28826 8.39085Z"
                        fill="#FBBB00"></path>
                    <path
                        d="M13.5502 5.75455C13.6267 6.15783 13.6667 6.57431 13.6667 6.99996C13.6667 7.47726 13.6165 7.94283 13.5209 8.39192C13.1963 9.92012 12.3483 11.2545 11.1736 12.1989L11.1733 12.1985L9.27108 12.1014L9.00186 10.4208C9.78134 9.96371 10.3905 9.24832 10.7114 8.39192H7.14655V5.75455H10.7634H13.5502Z"
                        fill="#518EF8"></path>
                    <path
                        d="M11.1732 12.1986L11.1736 12.1989C10.0311 13.1172 8.57981 13.6667 6.99997 13.6667C4.46114 13.6667 2.25382 12.2476 1.12781 10.1594L3.28825 8.39087C3.85124 9.89342 5.3007 10.963 6.99997 10.963C7.73036 10.963 8.41463 10.7656 9.00179 10.4209L11.1732 12.1986Z"
                        fill="#28B446"></path>
                    <path
                        d="M11.2553 1.86812L9.09558 3.63624C8.4879 3.2564 7.76957 3.03697 6.99999 3.03697C5.26225 3.03697 3.78569 4.15565 3.2509 5.71208L1.0791 3.93406H1.07874C2.18827 1.79486 4.42342 0.333328 6.99999 0.333328C8.61756 0.333328 10.1007 0.909526 11.2553 1.86812Z"
                        fill="#F14336"></path>
                </svg>
                <span class="ml-2">Continue with Google account</span>
        </a>        
        <p class="mt-9 text-center">Don't have an account? <a class="text-[#63B3A8]" href="register">Register</a></p>
      </div>
    </div>
  </section>
  <svg class="absolute bottom-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#63B3A8" fill-opacity="1"
      d="M0,128L48,154.7C96,181,192,235,288,234.7C384,235,480,181,576,138.7C672,96,768,64,864,96C960,128,1056,224,1152,256C1248,288,1344,256,1392,240L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
    </path>
  </svg>
</body>

</html>