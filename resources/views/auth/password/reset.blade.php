<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Reset Password</title>
</head>
<body class="bg-gray-100 w-full">
  <section class="min-h-screen flex flex-col items-center justify-center">
    <div class="z-50 bg-gray-100 flex flex-col sm:flex-row rounded-2xl shadow-lg max-w-3xl p-5">
      <div class="sm:w-1/2 sm:block hidden ">
        <img class="h-full rounded-2xl" src="../../assets/bed.jpg" alt="">
      </div>
      <div class="w-full sm:w-1/2 pl-7 pr-7">
        <h2 class="font-bold text-black text-2xl font-sans">Reset Password</h2>
        <form class="flex flex-col gap-2" form action="{{ route('password.store') }}" method="post">
          @csrf
          <input type="hidden" name="token" value="{{ $request->token }}">
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
          <div class="flex flex-col sm:flex-row w-[330px] bg-[#DCDCDC] mt-3 rounded-lg gap-2">
            <input
              class="bg-[#DCDCDC] p-2 ml-7 border-l-2 border-l-[#DCDCDC] rounded-lg text-black font-sans sm:w-[304px]"
              type="password" name="password" id="password" placeholder="New Password" required>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-key absolute translate-x-2 translate-y-3" viewBox="0 0 16 16">
              <path
                d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
              <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
            </svg>
          </div>
          <div class="flex flex-col sm:flex-row w-[330px] bg-[#DCDCDC] mt-3 rounded-lg gap-2">
            <input
              class="bg-[#DCDCDC] p-2 ml-7 border-l-2 border-l-[#DCDCDC] rounded-lg text-black font-sans sm:w-[304px]"
              type="password" name="password_confirmation" id="password-confirm" placeholder="Re-Enter Password" required>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-key absolute translate-x-2 translate-y-3" viewBox="0 0 16 16">
              <path
                d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
              <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
            </svg>
          </div>
          <div class="mt-3 flex justify-between items-center">
          </div>
          <button class="bg-[#63B3A8] text-white p-2 rounded-md font-sans" type="submit">Reset Password</button>
        </form>
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