@extends('theme::layouts.app')

@section('content')




    <div class="relative flex items-center w-full">
        <div class="relative z-20 px-8 mx-auto xl:px-5 max-w-7xl">

            <div class="flex flex-col items-center h-full pt-16 pb-56 lg:flex-row">

                <div class="flex flex-col items-start w-full mb-16 md:items-center lg:pr-12 lg:items-start lg:mb-0">

                    <h2 class="invisible text-sm font-semibold tracking-wide text-gray-700 uppercase transition-none duration-700 ease-out transform translate-y-12 opacity-0 sm:text-base lg:text-sm xl:text-base" data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>Welcome to Unformer</h2>
                    <h1 class="invisible pb-2 mt-3 text-4xl font-extrabold leading-10 tracking-tight text-transparent transition-none duration-700 ease-out delay-150 transform translate-y-12 opacity-0 bg-clip-text bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 scale-10 md:my-5 sm:leading-none lg:text-5xl xl:text-6xl" data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>Unformer is where PTCGO players go when they want to get better.</h1>
                    <p class="invisible max-w-2xl mt-0 text-base text-left text-gray-600 transition-none duration-700 ease-out delay-300 transform translate-y-12 opacity-0 md:text-center lg:text-left sm:mt-2 md:mt-0 sm:text-base lg:text-lg xl:text-xl" data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "scale-110": "scale-100", "opacity-0": "opacity-100" }'>Unformer offers skill-based matchmaking for the Pokemon Trading Card Game Online.</p>
                    <div class="invisible w-full mt-5 transition-none duration-700 ease-out transform translate-y-12 opacity-0 delay-450 sm:mt-8 sm:flex sm:justify-center lg:justify-start sm:w-auto" data-replace='{ "transition-none": "transition-all", "invisible": "visible", "translate-y-12": "translate-y-0", "opacity-0": "opacity-100" }'>
                        <div class="rounded-md">
                            <a href="{{ theme('home_cta_url') }}" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium leading-6 text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-500 hover:bg-wave-600 focus:outline-none focus:border-wave-600 focus:shadow-outline-indigo md:py-4 md:text-lg md:px-10">
                                {{ theme('home_cta') }}
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="/blog" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium leading-6 text-indigo-700 transition duration-150 ease-in-out bg-indigo-100 border-2 border-transparent rounded-md hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 md:py-4 md:text-lg md:px-10">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- BEGINNING OF TESTIMONIALS SECTION -->
    <div id="testimonials">
        <div class="relative flex items-center justify-center pt-32 pb-12 bg-gray-100 md:pb-32 lg:pb-64 min-w-screen">
            <div class="max-w-6xl px-10 pb-20 mx-auto bg-gray-100">
                <div class="flex flex-col items-center lg:flex-row">
                    <div class="flex flex-col justify-center w-full h-full mb-10 lg:pr-8 sm:w-4/5 md:items-center lg:mb-0 lg:items-start md:w-3/5 lg:w-1/2">
                        <p class="mb-2 text-base font-medium tracking-tight uppercase text-wave-500">The best players in the game play on Unformer</p>
                        <h2
                            class="text-4xl font-extrabold leading-10 tracking-tight text-gray-900 sm:leading-none lg:text-5xl xl:text-6xl">
                            Believe in the Power!</h2>
                        <p class="pr-5 my-6 text-lg text-gray-600 md:text-center lg:text-left">People asked for a ranked ladder, now there is a ranked ladder.</p>
                    </div>
                    <div class="w-full sm:w-4/5 lg:w-1/2">
                        <blockquote class="flex flex-row-reverse items-center justify-between w-full col-span-1 p-6 sm:flex-row">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">This is sick</p>&mdash; Falcon Main #387 (@Pokehead987) <a href="https://twitter.com/Pokehead987/status/1398814086905962496?ref_src=twsrc%5Etfw">May 30, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </blockquote>
                        <blockquote
                            class="flex flex-row-reverse items-center justify-between w-full col-span-1 p-6 my-5 sm:flex-row">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">I played some of <a href="https://twitter.com/bhalliburton?ref_src=twsrc%5Etfw">@bhalliburton</a>&#39;s ranked ladder tonight and it&#39;s a cool idea but we need more of you to use it so I can hit someone besides <a href="https://twitter.com/Gam3rALO?ref_src=twsrc%5Etfw">@Gam3rALO</a> and <a href="https://twitter.com/Vincius01763096?ref_src=twsrc%5Etfw">@Vincius01763096</a>&#39;s brother<br><br>👇bookmark it<a href="https://t.co/clWDNGYjy7">https://t.co/clWDNGYjy7</a></p>&mdash; Kevin Clemente (@Mellow_Magikarp) <a href="https://twitter.com/Mellow_Magikarp/status/1399549589858897923?ref_src=twsrc%5Etfw">June 1, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>                        </blockquote>
                        <blockquote
                            class="flex flex-row-reverse items-center justify-between w-full col-span-1 p-6 sm:flex-row">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr">I&#39;m queing right now! Who is trying to lose to GengaPult!? <a href="https://t.co/IOotyFFw2M">https://t.co/IOotyFFw2M</a></p>&mdash; AzulGG (@Azul_GG) <a href="https://twitter.com/Azul_GG/status/1398823911635177472?ref_src=twsrc%5Etfw">May 30, 2021</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>                        </blockquote>
                    </div>
                </div>
            </div>

            <svg version="1.1" id="Layer_3" xmlns="http://www.w3.org/2000/svg" class="absolute bottom-0 w-full" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 1440 126" style="enable-background:new 0 0 1440 126;" xml:space="preserve">
                <style type="text/css">
                    .wave-svg-light {
                        fill: #ffffff;
                    }
                </style>
                <g id="wave" transform="translate(720.000000, 75.000000) scale(1, -1) translate(-720.000000, -75.000000) " fill-rule="nonzero">
                    <path class="wave-svg-light" d="M694,94.437587 C327,161.381336 194,153.298248 0,143.434189 L2.01616501e-13,44.1765618 L1440,27 L1440,121 C1244,94.437587 999.43006,38.7246898 694,94.437587 Z" id="Shape" fill="#0069FF" opacity="0.519587054"></path>
                    <path class="wave-svg-light" d="M686.868924,95.4364002 C416,151.323752 170.73341,134.021565 1.35713663e-12,119.957876 L0,25.1467017 L1440,8 L1440,107.854321 C1252.11022,92.2972893 1034.37894,23.7359827 686.868924,95.4364002 Z" id="Shape" fill="#0069FF" opacity="0.347991071"></path>
                    <path class="wave-svg-light" d="M685.6,30.8323303 C418.7,-19.0491687 170.2,1.94304528 0,22.035593 L0,118 L1440,118 L1440,22.035593 C1252.7,44.2273621 1010,91.4098622 685.6,30.8323303 Z" id="Shape" fill="url(#linearGradient-1)" transform="translate(720.000000, 59.000000) scale(1, -1) translate(-720.000000, -59.000000) "></path>
                </g>
            </svg>

        </div>
    </div>
    <!-- END OF TESTIMONIALS SECTION -->


@endsection
