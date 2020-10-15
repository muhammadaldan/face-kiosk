@extends('layouts.app')

@section('content')
<!-- component -->
<section class="absolute w-full h-full top-0">
    <div class="absolute top-0 w-full h-full bg-gray-900"
        style="background-image: url(&quot;https://demos.creative-tim.com/tailwindcss-starter-project/static/media/register_bg_2.2fee0b50.png&quot;); background-size: 100%; background-repeat: no-repeat;">
    </div>
    <div class="container mx-auto px-4 h-full">
        <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-4/12 px-4 pt-32">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center mb-3">
                            <h6 class="text-gray-600 text-sm font-bold">Sign in to your account</h6>
                        </div>
                        <hr class="mt-6 border-b-1 border-gray-400">
                    </div>
                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                    for="grid-password">Email</label>
                                <input type="email"
                                    class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full @error('email') border-red-500 text-red-500 @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email"
                                    style="transition: all 0.15s ease 0s;">

                                @error('email')
                                <span class="text-xs text-red-500" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                    for="grid-password">Password</label>
                                <input type="password"
                                    class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                                    placeholder="Password" style="transition: all 0.15s ease 0s;" name="password">
                                @error('password')
                                <span class="text-xs text-red-500" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input id="remember" type="checkbox" name="remember"
                                        class="form-checkbox text-gray-800 ml-1 w-5 h-5"
                                        style="transition: all 0.15s ease 0s;"><span
                                        class="ml-2 text-sm font-semibold text-gray-700"
                                        {{ old('remember') ? 'checked' : '' }}>Remember me</span></label>
                            </div>
                            <div class="text-center mt-6">
                                <button
                                    class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                                    type="submit" style="transition: all 0.15s ease 0s;">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex flex-wrap mt-6">
                    <div class="w-1/2"><a href="#pablo" class="text-gray-300"><small>Forgot password?</small></a></div>
                    <div class="w-1/2 text-right"><a href="#pablo" class="text-gray-300"><small>Create new
                                account</small></a></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
