<div id="authModal"
     x-data="authPopup()"
     x-cloak>

  <!-- overlay -->
  <div x-show="open"
       x-transition.opacity
       class="fixed inset-0 bg-black/50 z-[9998]"
       @click="close()"></div>

  <!-- modal -->
  <div x-show="open"
       x-transition
       class="fixed inset-0 z-[9999] flex items-start justify-center overflow-y-auto px-4"
       style="padding: 2rem 0"
       @keydown.escape.window="close()">
    <div class="w-full max-w-[480px] rounded-2xl bg-white shadow-xl relative overflow-y-auto max-h-[90vh]">
      <div class="px-8 py-6">

        <!-- close -->
        <div class="sticky top-0 right-0 flex justify-end">
          <button @click="close()"
                  class="absolute right-4 top-4 text-zinc-500 hover:text-zinc-700"
                  aria-label="Close">
            ✕
          </button>
        </div>

        <!-- header -->
        <div class="px-2 pt-6 text-left">
          <h3 class="text-[26px] font-bold text-[#111]"
              x-text="mode === 'signin' ? 'Sign in' : (mode === 'password' ? 'Sign in' : (mode === 'register' ? 'Sign up' : 'Reset Password'))"></h3>
        </div>
        
        <!-- body -->
        <div class="px-2 mt-6 space-y-6">

          <!-- STEP 1: EMAIL -->
          <form x-show="mode === 'signin'" @submit.prevent="submitEmail" class="space-y-4">
            @csrf
            <p class="text-sm mt-3 text-gray-600">
              Don’t have an account?
              <button type="button" class="text-blue-600 underline" @click="switchTo('register')">Sign up</button>
            </p>
           <div class="flex items-center my-6"> 
            <hr class="flex-grow border-gray-400"> 
            <p class="mx-3 text-xs text-gray-500 md:text-sm whitespace-nowrap">Sign in or sign up with email</p> 
            <hr class="flex-grow border-gray-400"> 
          </div>

            <input type="email" id="email" placeholder="Email"
                   class="w-full h-11 rounded-lg border border-zinc-300 px-4 text-[15px] focus:outline-none focus:ring-2 focus:ring-black/10">
            <button type="submit"
                    class="w-full h-11 rounded-full bg-black text-white font-semibold hover:bg-black/90">
              Continue
            </button>

            
            <div class="flex items-center my-6"> 
              <hr class="flex-grow border-gray-400"> 
              <p class="mx-3 text-xs text-gray-500 md:text-sm whitespace-nowrap">Sign in or sign up with social account</p> 
              <hr class="flex-grow border-gray-400"> 
            </div>

            
            <!-- Social login -->
            <div class="mt-3 space-y-3">
              <a href="{{ route('social.redirect','google') }}"
                 class="flex h-12 w-full items-center justify-center gap-3 text-black rounded-full border border-gray-300 hover:bg-gray-100">
                <!-- @include('partials.svg.google') -->
                <img src="{{ asset('images/icons/google.svg') }}" />
                <span>Continue with Google</span>
              </a>
              <a href="{{ route('social.redirect','facebook') }}"
                 class="flex h-12 w-full items-center justify-center gap-3 text-black rounded-full border border-gray-300 hover:bg-gray-100">
                <!-- @include('partials.svg.facebook') -->
                <img src="{{ asset('images/icons/facebook.svg') }}" />
                <span>Continue with Facebook</span>
              </a>
              <a href="{{ route('social.redirect','apple') }}"
                 class="flex h-12 w-full items-center justify-center gap-3 text-black rounded-full border border-gray-300 hover:bg-gray-100">
                <img src="{{ asset('images/icons/apple.svg') }}" />
                <span>Continue with Apple</span>
              </a>
            </div>

            <!-- Disclaimer -->
            <p class="mt-4 text-xs text-gray-500 leading-relaxed">
              By clicking on Continue with Google, Facebook or Apple, you represent that you are 18+ years of age 
              and have read and agreed to the Nazo.com 
              <a href="{{ route('terms') }}" class="underline text-blue-600">Terms & Conditions</a>, 
              <a href="{{ route('privacy') }}" class="underline text-blue-600">Privacy Policy</a> and 
              <a href="{{ route('ca-privacy') }}" class="underline text-blue-600">CA Privacy Notice</a>. 
              Nazo.com may send you communications. You may change your preferences in your account preferences at any time.
            </p>
          </form>

          <!-- STEP 2: PASSWORD -->
          <form x-show="mode === 'password'" @submit.prevent="submitPassword" class="space-y-4">
            <p class="text-lg font-semibold">Welcome Back, <span x-text="userName"></span></p>
            <p class="text-sm text-gray-600">
              Email: <span x-text="signupEmail"></span>
              <button type="button" class="underline text-blue-600 ml-2" @click="switchTo('signin')">Change</button>
            </p>

            <!-- Error Message -->
            <div x-show="errorMessage" class="w-full p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md">
              <span x-text="errorMessage"></span>
            </div>

            <!-- Password Input -->
             <div class="relative">
              <input type="password" id="signin-password" placeholder="Password"
                    class="w-full h-11 rounded-lg border px-4 pr-10 text-[15px]"
                    :class="errorMessage ? 'border-red-500 focus:ring-red-500' : 'border-zinc-300 focus:ring-black/10'">

              <!-- Eye icon -->
              <button type="button" 
                      class="absolute inset-y-0 right-3 flex items-center text-gray-500"
                      @click="togglePassword('signin-password')">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                    class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
              <p x-show="errorMessage" class="text-xs text-red-600 mt-1">Please enter a password</p>
            </div>

            <!-- <div>
              <input type="password" id="password" placeholder="Password" class="w-full h-11 rounded-lg border px-4 text-[15px]" :class="errorMessage ? 'border-red-500 focus:ring-red-500' : 'border-zinc-300 focus:ring-black/10'">
                <p x-show="errorMessage" class="text-xs text-red-600 mt-1">Please enter a password</p>
            </div> -->

            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" class="h-4 w-4"> Remember me
            </label>

            <button type="submit"
                    class="w-full h-11 rounded-full bg-black text-white font-semibold hover:bg-black/90">
              Sign In
            </button>

            <div class="text-sm mt-4">
              <a href="{{ route('password.request') }}" class="underline text-gray-700">Forgot Password?</a>
            </div>


            <div class="space-y-2 mt-4">
              <button type="button" class="w-full h-11 rounded-full border">Email Me Sign In Link</button>
              <button type="button" class="w-full h-11 rounded-full border">Reset Password</button>
            </div>
          </form>

          <!-- STEP 3: SIGN UP -->
          <form x-show="mode === 'register'" method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <!-- Notice if coming from Sign in with unregistered email -->
            <div class="mb-3 p-3 rounded-md bg-yellow-50 border border-yellow-300 text-sm text-yellow-800"
                x-show="showSignupNotice">
              Looks like you don't have an account with us, follow the steps below to create an account.
            </div>

            <p class="text-sm">Sign up with email</p>

            <div class="flex gap-6 text-sm">
              <label><input type="radio" name="account_type" value="personal" checked> Personal Account</label>
              <label><input type="radio" name="account_type" value="business"> Business Account</label>
            </div>

           <!-- email field logic -->
            <template x-if="signupEmail">
              <p class="text-sm">
                Email: <span x-text="signupEmail"></span>
                <button type="button" class="underline text-blue-600 ml-2"
                        @click="signupEmail=''; showSignupNotice=false">Change</button>
                <input type="hidden" name="email" :value="signupEmail">
              </p>
            </template>
            <template x-if="!signupEmail">
              <input type="email" name="email" placeholder="Email"
                    class="w-full h-11 border rounded-md px-4">
            </template>

            <input type="text" name="name" placeholder="Full Name"
                   class="w-full h-11 rounded-lg border px-4 text-[15px]">
             <!-- Password Input -->
             <div class="relative">
                <input type="password" name="password" id="signup-password" placeholder="Password"
                      class="w-full h-11 rounded-lg border px-4 pr-10 text-[15px]"
                      :class="errorMessage ? 'border-red-500 focus:ring-red-500' : 'border-zinc-300 focus:ring-black/10'">

                <!-- Eye icon -->
                <button type="button" 
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500"
                        @click="togglePassword('signup-password')">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                      class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>

            <label class="flex items-center gap-2 text-sm">
              <input type="checkbox" class="h-4 w-4"> Remember me
            </label>

            <button type="submit"
                    class="w-full h-11 rounded-full bg-black text-white font-semibold hover:bg-black/90">
              Create Account
            </button>

            

            <div class="flex items-center my-6"> 
              <hr class="flex-grow border-gray-400"> 
              <p class="mx-3 text-xs text-gray-500 md:text-sm whitespace-nowrap">Sign in or sign up with social account</p> 
              <hr class="flex-grow border-gray-400"> 
            </div>

            <!-- Social -->
            <div class="mt-3 space-y-3">
              <a href="{{ route('social.redirect','google') }}"
                 class="flex h-12 w-full items-center justify-center gap-3 rounded-full border hover:bg-gray-100">
                <!-- @include('partials.svg.google') -->
                 <img src="{{ asset('images/icons/google.svg') }}" />
                <span>Continue with Google</span>
              </a>
              <a href="{{ route('social.redirect','facebook') }}"
                 class="flex h-12 w-full items-center justify-center gap-3 rounded-full border hover:bg-gray-100">
                <!-- @include('partials.svg.facebook') -->
                <img src="{{ asset('images/icons/facebook.svg') }}" />
                <span>Continue with Facebook</span>
              </a>
              <a href="{{ route('social.redirect','apple') }}"
                 class="flex h-12 w-full items-center justify-center gap-3 rounded-full border hover:bg-gray-100">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 384 512">
                  <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8..."/>
                </svg> -->
                <img src="{{ asset('images/icons/apple.svg') }}" />
                <span>Continue with Apple</span>
              </a>
            </div>
            <p class="text-sm text-center mt-3 font-semibold">Already have an account? 
              <button type="button" class="text-blue-600 underline" @click="switchTo('signin')">Sign in</button>
            </p>
            <!-- Disclaimer -->
            <p class="mt-4 text-xs text-gray-500 leading-relaxed">
              By clicking on Continue with Google, Facebook or Apple, you represent that you are 18+ years of age 
              and have read and agreed to the Nazo.com 
              <a href="{{ route('terms') }}" class="underline text-blue-600">Terms & Conditions</a>, 
              <a href="{{ route('privacy') }}" class="underline text-blue-600">Privacy Policy</a> and 
              <a href="{{ route('ca-privacy') }}" class="underline text-blue-600">CA Privacy Notice</a>. 
              Nazo.com may send you communications. You may change your preferences in your account preferences at any time.
            </p>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<script>
window.authPopup = () => ({
  open: false,
  mode: 'signin',
  signupEmail: '',
  userName: '',
  showSignupNotice: false,  // FIX ADDED
  errorMessage: '',
  showPassword: false,

  switchTo(m) { this.mode = m; },
  openWith(m = 'signin') { this.mode = m; this.open = true; document.body.classList.add('overflow-hidden'); },
  close() { this.open = false; document.body.classList.remove('overflow-hidden'); },

  async submitEmail() {
    let email = document.querySelector('#email').value;
    try {
      let res = await fetch("{{ route('login.check') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute("content"),
        },
        body: JSON.stringify({ email }),
      });
      let data = await res.json();

      if (data.success && data.exists) {
        this.mode = 'password';
        this.userName = data.name;
        this.signupEmail = email;
      } else {
        this.signupEmail = email;
        this.switchTo('register');
        this.showSignupNotice = true;
      }
    } catch (e) { console.error(e); alert("Something went wrong"); }
  },

   async submitPassword() {
    let email = this.signupEmail;
    // let password = document.querySelector('#password').value;    
    let passwordInput = document.querySelector('form[x-show="mode === \'password\'"] input[type="password"]');
    let password = passwordInput ? passwordInput.value : '';
    this.errorMessage = ''; // reset
  

    try {
      let res = await fetch("{{ route('auth.login') }}", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute("content"),
        },
        body: new URLSearchParams({ email, password })
      });

      let data = await res.json();

      if (data.success) {
        window.location.href = data.redirect;
      } else {
        this.errorMessage = data.message || "Sorry, that email address and/or password doesn't match our records.";
      }
    } catch (e) {
      console.error("Login error", e);
      this.errorMessage = "Something went wrong. Please try again.";
    }
  },
 togglePassword(id) {
  let input = document.getElementById(id);
  if (!input) return;
  input.type = input.type === "password" ? "text" : "password";
},


});


// Global trigger
window.showAuth = (mode = 'signin') => {
  const el = document.getElementById('authModal');
  if (!el) return;
  const comp = el._x_dataStack && el._x_dataStack[0];
  if (comp && typeof comp.openWith === 'function') {
    comp.openWith(mode);
  } else {
    window.dispatchEvent(new CustomEvent('auth:open', { detail: { mode } }));
  }
};
</script>
