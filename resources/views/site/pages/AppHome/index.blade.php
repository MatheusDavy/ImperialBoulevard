@extends('site.layout.app')
@section('content')
<section id="page-home">
    <div class="section_herobanner" id="inicio">
        <div class="section_herobanner--container">
            <div class="box_slider swiper heroBannerSlider">
                <div class="swiper-wrapper">
                    @foreach ($firstSection->gallery as $gallery)
                    <div class="swiper-slide box_slider--content">
                        <img src="{{ assetJson([$firstSection->folder,$gallery->image]) }}" alt="{{imgAltJson($gallery->image)}}" title="{{imgTitleJson($gallery->image)}}">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="box_text">
                <span class="box_text--text">{{$firstSection->above_title}}</span>
                <div class="style style_one">

                </div>
                <img class="box_text--logo" src="{{ asset('site/img/Home/Banner/logo-text.png') }}" />
                <p class="box_text--description">
                    {!! ignoreTags($firstSection->subtitle) !!}
                </p>
                <a href="{{$firstSection->button_link}}" class="box_text--link" aria-label="Ir para a sessão de Saiba Mais">{{$firstSection->button_title}}</a>

                <a href="" class="box_text--locale">
                    <img src="{{ asset('site/img/Icons/pinner.svg') }}" alt="">
                    <span style="opacity: 0.6;">{{$firstSection->location}}</span>
                </a>
                <div class="style style_two"></div>

                <canvas class="section_herobanner--background"></canvas>
            </div>
        </div>

        @include('site.components.Fixed.next_section')
    </div>

    <div class="section_region" id="regiao">
        <svg class="region_line-1" xmlns="http://www.w3.org/2000/svg" width="1920" height="2" viewBox="0 0 1920 2" fill="none">
            <path d="M0 1H1920" stroke="#F1F1F1" stroke-opacity="0.3" />
        </svg>
        <svg class="region_line-2" xmlns="http://www.w3.org/2000/svg" width="2" height="1080" viewBox="0 0 2 1080" fill="none">
            <path d="M1 0V1080" stroke="#F1F1F1" stroke-opacity="0.3" stroke-linejoin="round" />
        </svg>
        <svg class="region_line-3" xmlns="http://www.w3.org/2000/svg" width="2" height="1080" viewBox="0 0 2 1080" fill="none">
            <path d="M1 0V1080" stroke="#F1F1F1" stroke-opacity="0.3" stroke-linejoin="round" />
        </svg>
        <div class="section_region--container">

            <div class="box_grid box_grid--one">
                <div class="box_text">
                    <div class="grid-one">
                        <span class="box_text--text" data-animation>{{$secondSection->above_title}}</span>
                        <h2 class="box_text--title" data-animation='right'>{{ $secondSection->title }}</h2>

                        <div class="box_text--list" data-animation>
                            {!! $secondSection->description !!}
                        </div>
                    </div>
                    <div class="box_text--image image-block reveal">
                        <div class="image-wrap">
                            <img src="{{ assetJson([$secondSection->folder,$secondSection->image_top]) }}" alt="{{imgAltJson($secondSection->image_top)}}" title="{{imgTitleJson($secondSection->image_top)}}">
                        </div>
                    </div>
                </div>

                <div class="box_image image-block reveal">
                    <div class="image-wrap">
                        <img src="{{ assetJson([$secondSection->folder,$secondSection->image_bottom]) }}" alt="{{imgAltJson($secondSection->image_bottom)}}" title="{{imgTitleJson($secondSection->image_bottom)}}">
                    </div>
                </div>
            </div>

            <div class="box_grid box_grid--two image-block reveal">
                <div class="image-wrap">
                    <img src="{{ assetJson([$secondSection->folder,$secondSection->image_right]) }}" alt="{{imgAltJson($secondSection->image_right)}}" title="{{imgTitleJson($secondSection->image_right)}}">
                </div>
            </div>

            <div class="box_grid_mobile">
                <div class="box_grid_mobile--image image-block reveal">
                    <div class="image-wrap">
                        <img src="{{ assetJson([$secondSection->folder,$secondSection->image_top]) }}" alt="{{imgAltJson($secondSection->image_top)}}" title="{{imgTitleJson($secondSection->image_top)}}">
                    </div>
                </div>
                <div class="box_grid_mobile--image image-block reveal">
                    <div class="image-wrap">
                        <img src="{{ assetJson([$secondSection->folder,$secondSection->image_bottom]) }}" alt="{{imgAltJson($secondSection->image_bottom)}}" title="{{imgTitleJson($secondSection->image_bottom)}}">
                    </div>
                </div>
                <div class="box_grid_mobile--image image-block reveal">
                    <div class="image-wrap">
                        <img src="{{ assetJson([$secondSection->folder,$secondSection->image_right]) }}" alt="{{imgAltJson($secondSection->image_right)}}" title="{{imgTitleJson($secondSection->image_right)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section_convention" id="boulevard-convention">
        <div class="section_convention--container">
            <div class="box_text">
                <span class="box_text--text" data-animation>{{ $thirdSection->above_title }}</span>
                <h2 class="box_text--title" data-animation='right'>{{ $thirdSection->title }}</h2>

                <p class="box_text--description" data-animation='left'>
                    {{ $thirdSection->subtitle }}
                </p>

                <div class="box_text--list" data-animation>
                    {!! $thirdSection->description !!}
                </div>
            </div>

            <div class="box_image image-block">
                <img src="{{ assetJson([$thirdSection->folder,$thirdSection->image_right]) }}" alt="{{imgAltJson($thirdSection->image_right)}}" title="{{imgTitleJson($thirdSection->image_right)}}">

                <div class="box-detail">
                    <div class="image-wrap">
                        <img src="{{ assetJson([$thirdSection->folder,$thirdSection->image_left]) }}" alt="{{imgAltJson($thirdSection->image_left)}}" title="{{imgTitleJson($thirdSection->image_left)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section_about" id="meeting-plus">
        <svg class="about_line-1" xmlns="http://www.w3.org/2000/svg" width="2" height="2117" viewBox="0 0 2 2117" fill="none">
            <path opacity="0.3" d="M1 0L1.00009 2117" stroke="#F1F1F1" />
        </svg>
        <svg class="about_line-2" xmlns="http://www.w3.org/2000/svg" width="1920" height="2" viewBox="0 0 1920 2" fill="none">
            <path opacity="0.3" d="M0 1H1920" stroke="#F1F1F1" />
        </svg>
        <svg class="about_line-3" xmlns="http://www.w3.org/2000/svg" width="2" height="1181" viewBox="0 0 2 1181" fill="none">
            <path opacity="0.3" d="M1 0L1.00005 1181" stroke="#F1F1F1" />
        </svg>
        <div class="section_about--container">
            <div class="box_grid box_grid--one">
                <div class="box_text">
                    <svg data-animation='up' class="box_text--logo" width="458" height="86" viewBox="0 0 458 86" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_145_358" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="458" height="86">
                            <path d="M458 0.80542H0V85.4996H458V0.80542Z" fill="white" />
                        </mask>
                        <g mask="url(#mask0_145_358)">
                            <path d="M43.4409 0.80542C55.4357 0.80542 66.2959 5.54829 74.1562 13.2106C82.0164 20.873 86.8818 31.4597 86.8818 43.1525C86.8818 54.8453 82.0164 65.4321 74.1562 73.0944C66.2959 80.7567 55.4357 85.4996 43.4409 85.4996C31.4461 85.4996 20.5859 80.7617 12.7256 73.0944C4.86538 65.4321 0 54.8453 0 43.1525C0 31.4597 4.86538 20.873 12.7256 13.2106C20.5859 5.54829 31.4461 0.80542 43.4409 0.80542ZM71.7746 15.5322C64.5225 8.46277 54.5056 4.09355 43.4409 4.09355C32.3762 4.09355 22.3593 8.46277 15.1072 15.5322C7.85514 22.6017 3.36795 32.3665 3.36795 43.1525C3.36795 53.9386 7.85514 63.7033 15.1021 70.7728C22.3542 77.8423 32.3711 82.2115 43.4358 82.2115C54.5004 82.2115 64.5174 77.8373 71.7695 70.7728C79.0216 63.7033 83.5036 53.9386 83.5036 43.1525C83.5036 32.3665 79.0164 22.6017 71.7695 15.5322" fill="#D2A671" />
                            <path d="M29.7494 42.799C30.9759 42.0667 32.2843 41.4738 33.6437 41.0155V20.5842C32.9129 20.8782 32.228 21.1522 31.5841 21.4013C30.8993 21.6653 30.2758 21.8995 29.7238 22.0938C29.1923 22.2831 28.6097 22.4674 27.9862 22.6418C27.3575 22.8162 26.6829 22.9856 25.9623 23.155C25.0015 23.3742 23.8721 23.5734 22.763 23.6332C21.8738 23.6831 20.9947 23.6482 20.2128 23.4788C19.6302 23.3542 19.0731 23.1749 18.5723 22.9009C18.0765 22.6269 17.6421 22.2532 17.3201 21.7351C16.9982 21.212 16.8193 20.5693 16.8295 19.9416C16.8397 19.2889 17.0646 18.6114 17.5348 18.0036L17.7546 17.7495C18.1992 17.2812 18.7051 16.9922 19.1855 16.9274C19.5842 16.8726 19.993 16.9623 20.3457 17.2214L20.4683 17.321L20.5705 17.4207C20.8414 17.7096 20.9487 18.0434 20.9181 18.3822C20.8823 18.8057 20.6319 19.269 20.2179 19.7124L19.9113 20.0113C19.8295 20.1408 19.7988 20.2953 19.8244 20.4746C19.8499 20.6988 19.9675 20.923 20.1566 21.1223C20.2843 21.2568 20.4428 21.3913 20.637 21.5109C20.913 21.6853 21.2094 21.8148 21.5314 21.8995C21.8533 21.9842 22.2009 22.029 22.5688 22.029C23.2485 22.029 23.9794 21.9692 24.7562 21.8497C25.5228 21.7301 26.3252 21.5557 27.1531 21.3166C28.0066 21.0725 28.855 20.8084 29.6931 20.5245C30.5313 20.2355 31.3694 19.9216 32.2127 19.5779L33.2297 19.1644C38.1411 17.1516 43.3285 15.0293 48.7203 15.0293C50.7441 15.0293 53.0081 15.2535 55.1188 15.8414C56.8616 16.3246 58.5021 17.062 59.8258 18.1231C60.9961 19.0647 61.9416 20.1757 62.5805 21.4212C63.1886 22.6119 63.5259 23.9322 63.5259 25.362C63.5259 27.0808 62.8922 28.7846 61.9212 30.349C60.9042 31.9831 59.5243 33.4428 58.0933 34.5937C59.9893 35.336 61.8139 36.3025 63.4442 37.5081C65.0131 38.6739 66.393 40.0589 67.4765 41.688C68.8717 43.7805 69.6894 46.2466 69.9552 48.7725C70.2312 51.4079 69.899 54.1231 69.0046 56.5643C68.2891 58.5123 67.2772 60.2311 66.0097 61.7855C64.7321 63.3548 63.2193 64.7199 61.5123 65.9654C59.1512 67.6842 56.3914 68.9944 53.5039 69.8812C50.509 70.8029 47.3557 71.2762 44.3557 71.2762C41.6675 71.2762 38.8822 70.8627 36.2246 70.0656C33.6539 69.2934 31.2008 68.1625 29.0696 66.6878C27.0407 65.2878 25.2622 63.4794 24.0254 61.3919C22.9061 59.4987 22.2366 57.3764 22.2366 55.1146C22.2366 53.4406 22.5331 51.7866 23.1259 50.2322C23.729 48.6678 24.6438 47.1932 25.8806 45.8829C27.0458 44.6523 28.349 43.626 29.7442 42.7891M35.5755 39.8198V53.5851C35.5755 53.874 35.5449 54.168 35.4836 54.4569H38.0849C38.0491 54.3722 38.0133 54.2826 37.9878 54.1929C37.8447 53.7744 37.7783 53.341 37.7783 52.9026V19.3836C37.0372 19.6676 36.3064 19.9565 35.5807 20.2504V39.8347L35.5755 39.8198ZM27.2809 47.1782C26.2587 48.2593 25.4615 49.5148 24.93 50.8948C24.4138 52.2399 24.1634 53.6748 24.1634 55.1146C24.1634 57.0127 24.7306 58.8162 25.6966 60.4503C26.6778 62.1093 28.0577 63.569 29.6165 64.7398C27.4138 62.3086 26.0543 59.3343 25.6966 56.111C25.3542 53.047 25.9317 49.9582 27.286 47.1832M62.7951 62.4282C63.3982 61.8552 63.9655 61.2524 64.4919 60.6097C65.6469 59.1899 66.5515 57.6355 67.175 55.9266C67.9876 53.7196 68.2636 51.2934 68.0233 48.9618C67.7934 46.7597 67.0932 44.5726 65.8513 42.7143C64.8905 41.2745 63.6588 40.044 62.2636 39.0027C61.7321 38.6092 61.1801 38.2455 60.6128 37.9067C61.4919 38.8035 62.2789 39.7849 62.9791 40.8262C64.497 43.073 65.3658 45.6936 65.7133 48.354C66.0864 51.1887 65.8922 54.163 65.1716 56.933C64.6707 58.861 63.8479 60.7293 62.79 62.4282M59.9638 29.8059C60.066 29.6565 60.1631 29.507 60.2551 29.3576C61.0013 28.1669 61.5788 26.7669 61.5788 25.352C61.5788 24.2659 61.3335 23.2247 60.8377 22.2532C60.3011 21.207 59.5038 20.3102 58.5788 19.5679C58.405 19.4284 58.2261 19.2989 58.0422 19.1743C58.681 19.9914 59.2023 20.8981 59.6009 21.8845C59.8667 22.5472 60.0711 23.2297 60.2091 23.9272C60.3471 24.6247 60.4135 25.3321 60.4135 26.0395C60.4135 27.31 60.2755 28.5804 59.9587 29.8059M41.8157 54.9253V56.3501H31.5177V54.8555H32.6931C33.0253 54.8555 33.2297 54.7758 33.3217 54.6612C33.521 54.4171 33.6335 54.0036 33.6335 53.5951V43.083C32.6829 43.6161 31.8498 44.2388 31.1395 44.9513C30.3933 45.6986 29.7596 46.5804 29.2281 47.5917C27.8482 50.2172 27.2962 53.1118 27.6131 55.9117C27.9197 58.6568 29.0696 61.3022 31.0832 63.5192C32.2536 64.8046 33.5722 65.9056 35.0236 66.8073C36.4648 67.7091 38.044 68.4115 39.7254 68.8998C42.7203 69.7716 46.1853 69.8812 49.4715 69.2435C52.5788 68.6457 55.497 67.4002 57.6691 65.5319C58.9723 64.411 60.1375 63.031 61.0881 61.5164C62.0745 59.9421 62.836 58.2134 63.2908 56.4647C63.9297 53.9986 64.1392 51.2485 63.7866 48.5881C63.4697 46.1719 62.6878 43.8353 61.3539 41.8574C60.572 40.6966 59.6929 39.6454 58.7066 38.7188C57.7304 37.8021 56.6367 37.005 55.4102 36.3324C54.2296 36.9651 53.0286 37.4384 51.8122 37.7572C50.5652 38.0811 49.2927 38.2455 47.9945 38.2455C47.2841 38.2455 45.8276 38.2106 44.5499 37.9167C43.2518 37.6177 42.1326 37.0498 42.1326 35.9836C42.1326 35.5054 42.3728 35.0171 42.8481 34.5189C43.2569 34.0905 43.7987 33.7368 44.4733 33.4528C45.0661 33.2037 45.7407 33.0144 46.492 32.8948C47.2279 32.7752 48.0456 32.7154 48.9451 32.7154C49.9979 32.7154 51.0967 32.8051 52.2313 32.9845C53.3199 33.1539 54.4545 33.4129 55.6248 33.7517C56.4885 32.8798 57.1631 31.8585 57.6333 30.6977C58.1904 29.3227 58.4715 27.7733 58.4715 26.0395C58.4715 25.4417 58.4152 24.8538 58.3028 24.2809C58.1904 23.698 58.0166 23.1251 57.7968 22.5721C57.0149 20.6341 55.7219 19.1843 54.112 18.2078C52.3795 17.1516 50.2841 16.6435 48.0559 16.6435C46.7731 16.6435 45.383 16.7929 43.8804 17.0968C42.567 17.3609 41.1718 17.7395 39.6948 18.2327V39.7899C41.2995 39.6753 42.9094 39.7301 44.4835 39.9842C45.9605 40.2233 47.4017 40.6518 48.7816 41.2945C50.6061 42.1514 52.1444 43.2922 53.1972 44.747C54.1478 46.0722 54.6998 47.6565 54.6998 49.5297C54.6998 50.5859 54.5056 51.5574 54.1223 52.4342C53.693 53.4207 53.0286 54.3075 52.1291 55.0946C51.3063 55.812 50.4528 56.3501 49.5686 56.6988C48.7254 57.0277 47.8412 57.197 46.9162 57.197C46.2467 57.197 45.6436 57.1223 45.107 56.9778C44.5653 56.8284 44.0849 56.6042 43.6607 56.3053C43.2365 56.0063 42.9196 55.6775 42.705 55.3338C42.4903 54.9751 42.3779 54.5915 42.3779 54.1829C42.3779 53.2065 42.9809 52.5787 43.7475 52.2748C43.9366 52.2001 44.1308 52.1652 44.3251 52.1652C44.509 52.1652 44.6879 52.1951 44.8463 52.2549C45.2603 52.4044 45.5823 52.7481 45.5823 53.2463C45.5823 53.5552 45.4596 53.7993 45.3523 54.0235C45.3012 54.1281 45.2501 54.2278 45.2501 54.3224C45.2501 54.716 45.5005 55 45.8532 55.1943C46.3693 55.4832 47.0899 55.5779 47.5601 55.5779C48.4136 55.5779 49.1904 55.4334 49.8957 55.1395C50.5397 54.8754 51.1069 54.4968 51.5976 54.0036C52.5993 52.9972 53.1052 51.7268 53.1052 50.2123C53.1052 49.3205 52.957 48.4835 52.6606 47.7013C52.3642 46.9092 51.9144 46.1719 51.3165 45.4893C50.1053 44.0944 48.5567 43.098 46.8497 42.4353C44.9026 41.6781 42.7561 41.3493 40.6811 41.3493C40.4971 41.3493 40.2569 41.3592 39.9707 41.3742L39.6999 41.3891V52.8976C39.6999 53.1417 39.7357 53.3758 39.8123 53.6C39.889 53.8242 40.0065 54.0434 40.1598 54.2427C40.6198 54.8455 41.0184 54.8455 41.6777 54.8455H41.8157V54.9153V54.9253ZM51.6691 36.1779C52.2824 35.9836 52.8752 35.7196 53.4476 35.4007C52.1546 34.8876 50.6572 34.489 49.1598 34.3645C47.8003 34.2549 46.4562 34.3744 45.2808 34.8527C44.9179 35.0022 44.6777 35.1267 44.5908 35.2214C44.5755 35.2363 44.6113 35.2214 44.6113 35.2762C44.6061 35.4107 44.6624 35.5552 44.7952 35.6947C44.969 35.879 45.2654 36.0634 45.7049 36.2228C46.4562 36.5018 47.4272 36.6363 48.6385 36.6363C49.6964 36.6363 50.7032 36.4818 51.664 36.173" fill="#D2A671" />
                        </g>
                        <path d="M119.437 20.3696H118.042V65.9301H119.437V20.3696Z" fill="white" />
                        <path d="M157.047 17.9785H164.299L177.193 39.7798L190.036 17.9785H197.176V57.5855H190.317V29.9603L179.355 48.6827H174.924L163.854 29.9055V57.5855H157.047V17.9785Z" fill="white" />
                        <mask id="mask1_145_358" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="458" height="86">
                            <path d="M458 0.80542H0V85.4996H458V0.80542Z" fill="white" />
                        </mask>
                        <g mask="url(#mask1_145_358)">
                            <path d="M224.165 39.994C223.332 36.0034 220.399 33.9508 216.525 33.9508C212.431 33.9508 209.329 36.4319 208.333 39.994H224.165ZM201.689 43.3967C201.689 34.6533 208.108 28.4507 216.576 28.4507C224.324 28.4507 231.3 33.5772 230.636 44.8016H208.108C208.665 49.3353 212.15 52.464 217.133 52.464C220.787 52.464 223.884 50.795 226.046 47.7211L230.584 51.2284C227.707 55.2738 223.164 58.2431 216.97 58.2431C207.837 58.2431 201.694 51.9857 201.694 43.4067" fill="white" />
                            <path d="M255.79 39.994C254.962 36.0034 252.029 33.9508 248.15 33.9508C244.051 33.9508 240.954 36.4319 239.962 39.994H255.79ZM233.318 43.3967C233.318 34.6533 239.738 28.4507 248.206 28.4507C255.959 28.4507 262.93 33.5772 262.271 44.8016H239.738C240.289 49.3353 243.78 52.464 248.763 52.464C252.417 52.464 255.519 50.795 257.676 47.7211L262.214 51.2284C259.332 55.2738 254.794 58.2431 248.594 58.2431C239.462 58.2431 233.318 51.9857 233.318 43.4067" fill="white" />
                        </g>
                        <path d="M267.928 35.0867H264.381V29.0386H267.928V21.436L274.792 19.1692V29.0386H278.39V35.0867H274.792L274.736 57.5855H267.872L267.928 35.0867Z" fill="white" />
                        <path d="M282.213 29.0387H289.076V57.5856H282.213V29.0387ZM282.213 19.1643H289.076V25.8601H282.213V19.1643Z" fill="white" />
                        <mask id="mask2_145_358" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="458" height="86">
                            <path d="M458 0.80542H0V85.4996H458V0.80542Z" fill="white" />
                        </mask>
                        <g mask="url(#mask2_145_358)">
                            <path d="M306.361 28.396C313.94 28.396 318.534 32.9844 318.534 40.587V57.5856H311.676V40.8062C311.676 36.8106 309.739 34.6484 306.361 34.6484C302.983 34.6484 301.046 36.8106 301.046 40.8062V57.5856H294.182V40.587C294.182 32.9794 298.72 28.396 306.361 28.396Z" fill="white" />
                            <path d="M337.592 51.1688C342.299 51.1688 346.01 48.1448 346.01 42.9635C346.01 37.7822 342.299 34.6485 337.541 34.6485C332.783 34.6485 329.073 37.9964 329.073 42.9087C329.073 47.8209 332.615 51.1639 337.597 51.1639M329.63 62.2737H336.161C342.248 62.2737 345.683 60.0617 345.739 54.8306V53.5851C343.802 55.8519 340.643 57.0925 336.826 57.0925C328.689 57.0925 322.214 51.4827 322.214 42.9037C322.214 34.3247 328.746 28.4907 336.718 28.4907C340.597 28.4907 344.139 29.8957 346.24 32.4863L346.296 29.0338H352.383V54.2378C352.383 63.7335 346.132 68.3169 335.998 68.3169H329.635V62.2688L329.63 62.2737Z" fill="white" />
                            <path d="M383.118 35.9486C387.325 35.9486 389.762 33.8462 389.762 30.2841C389.762 26.7219 387.325 24.5647 383.118 24.5647H378.079V35.9486H383.118ZM370.883 17.9835H383.118C391.699 17.9835 397.071 22.6217 397.071 30.2841C397.071 37.9464 391.704 42.3704 383.118 42.3704H378.079V57.5855H370.883V17.9785V17.9835Z" fill="#D2A671" />
                        </g>
                        <path d="M407.328 17.9785H400.464V57.5855H407.328V17.9785Z" fill="#D2A671" />
                        <mask id="mask3_145_358" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="1" width="458" height="86">
                            <path d="M458 1.79468H0V86.4889H458V1.79468Z" fill="white" />
                        </mask>
                        <g mask="url(#mask3_145_358)">
                            <path d="M424.55 59.2221C416.971 59.2221 412.372 54.6336 412.372 47.0311V30.0325H419.235V46.8169C419.235 50.8124 421.172 52.9697 424.55 52.9697C427.929 52.9697 429.866 50.8124 429.866 46.8169V30.0325H436.729V47.0311C436.729 54.6386 432.191 59.2221 424.55 59.2221Z" fill="#D2A671" />
                            <path d="M441.063 58.5746V52.8004C443.389 53.1243 445.274 53.2289 446.542 53.2289C449.588 53.2289 450.973 52.367 450.973 50.5834C450.973 49.1835 450.084 48.1572 447.758 46.5928L445.934 45.3473C442.336 42.9161 440.787 40.6543 440.787 37.5206C440.787 32.6133 444.549 29.644 450.973 29.644C452.297 29.644 453.901 29.7536 455.567 30.0227V35.3136C453.901 35.0993 452.634 35.0396 451.857 35.0396C448.923 35.0396 447.431 35.9064 447.431 37.416C447.431 38.4921 448.315 39.4088 450.584 40.8685L452.358 42.0542C456.344 44.6997 458 47.1807 458 50.5237C458 55.8146 453.901 58.9433 446.874 58.9433C445.377 58.9433 443.22 58.7788 441.058 58.5646" fill="#D2A671" />
                        </g>
                    </svg>

                    <div class="box_text--description" data-animation>
                        {!! $fourthSection->description_1 !!}
                    </div>

                </div>

                <div class="box_image image-block">
                    <img src="{{ assetJson([$fourthSection->folder,$fourthSection->image_1]) }}" alt="{{imgAltJson($fourthSection->image_1)}}" title="{{imgTitleJson($fourthSection->image_1)}}">
                </div>

            </div>
            <div class="box_grid box_grid--two" data-animation='left'>
                <div class="box_card box_card--one">
                    <p class="box_card--description">
                        {!! ignoreTags($fourthSection->description_2) !!}
                    </p>
                </div>


                <div class="box_card  box_card--two" data-animation='right'>
                    <img class="box_card--logo" src="{{ asset('site/img/Home/Banner/logo-text.png') }}" />
                    <p class="box_card--description">
                        {!! ignoreTags($fourthSection->subtitle_2) !!}
                    </p>
                </div>
            </div>

            <div class="box_plant">
                <div class="f-panzoom" id="myPanzoom" data-lenis-prevent>
                    <div class="f-panzoom__viewport">
                        <img class="f-panzoom__content" src="{{ assetJson([$fourthSection->folder,$fourthSection->image_2]) }}" alt="{{imgAltJson($fourthSection->image_2)}}" title="{{imgTitleJson($fourthSection->image_2)}}">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section_differential" id="diferenciais">
        <svg class="differential_line-1" xmlns="http://www.w3.org/2000/svg" width="2" height="1289" viewBox="0 0 2 1289" fill="none">
            <path opacity="0.3" d="M1 0L0.999944 1289" stroke="#F1F1F1" />
        </svg>
        <svg class="differential_line-2" xmlns="http://www.w3.org/2000/svg" width="2" height="1289" viewBox="0 0 2 1289" fill="none">
            <path opacity="0.3" d="M1 0L0.999944 1289" stroke="#F1F1F1" />
        </svg>
        <div class="section_differential--container">
            <div class="box_text">
                <div class="box_grid box_grid--one">
                    <h2 class="box_text--title" data-animation='right'>{{$fifthSection->title}}</h2>
                    <div class="details details--line"></div>
                </div>
                <div class="box_grid box_grid--one" data-animation>
                    <p class="box_text--description">
                        {!! ignoreTags($fifthSection->subtitle) !!}
                    </p>
                </div>
            </div>

            <div class="box_image_desktop" data-animation='up'>
                <div class="box_image_desktop--grid-one">
                    <div class="item-one">
                        @php $gallery = $fifthSection->gallery @endphp
                        @if (isset($gallery[0]) && $gallery[0])
                        <div class="image-one image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[0]])
                        </div>
                        @endif
                        @if (isset($gallery[1]) && $gallery[1])
                        <div class="image-two image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[1]])
                        </div>
                        @endif
                    </div>
                    <div class="item-two">
                        @if (isset($gallery[2]) && $gallery[2])
                        <div class="image-one image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[2]])
                        </div>
                        @endif
                        @if (isset($gallery[3]) && $gallery[3])
                        <div class="image-two image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[3]])
                        </div>
                        @endif
                    </div>
                </div>

                <div class="box_image_desktop--grid-two">
                    <div class="item-one">
                        @if (isset($gallery[4]) && $gallery[4])
                        <div class="image-one image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[4]])
                        </div>
                        @endif
                        @if (isset($gallery[5]) && $gallery[5])
                        <div class="image-two image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[5]])
                        </div>
                        @endif
                    </div>
                    <div class="item-two">
                        @if (isset($gallery[6]) && $gallery[6])
                        <div class="image image-block">
                            @include('site.components.ImagesDiferencias', ['gallery' => $gallery[6]])
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="box_image_mobile" data-animation='up'>
                <div class="image-one image-block">
                    @include('site.components.ImagesDiferencias', ['gallery' => $gallery[0]])
                </div>
                <div class="box_image_mobile--grid-one">
                    <div class="image-two image-block">
                        @include('site.components.ImagesDiferencias', ['gallery' => $gallery[1]])
                    </div>
                    <div class="image-three image-block">
                        @include('site.components.ImagesDiferencias', ['gallery' => $gallery[2]])
                    </div>
                </div>
                <div class="box_image_mobile--grid-two">
                    <div class="image-four image-block">
                        @include('site.components.ImagesDiferencias', ['gallery' => $gallery[3]])
                    </div>
                    <div class="image-five image-block">
                        @include('site.components.ImagesDiferencias', ['gallery' => $gallery[4]])
                    </div>
                    <div class="image-six image-block">
                        @include('site.components.ImagesDiferencias', ['gallery' => $gallery[5]])
                    </div>
                </div>
                <div class="image-seven image-block">
                    @include('site.components.ImagesDiferencias', ['gallery' => $gallery[0]])
                </div>
            </div>
        </div>

    </div>

    <div class="section_investing" id="invista">
        <div class="section_investing--container">
            <div class="box_text">
                <span class="box_text--text" data-animation>{{$sixthSection->above_title}}</span>
                <h2 class="box_text--title" data-animation='right'>
                    {!! ignoreTags($sixthSection->title) !!}
                </h2>

                <div class="box_text--description" data-animation>
                    {!! $sixthSection->description !!}
                </div>

                <a class="box_text--link" data-animation='up' href="{{$sixthSection->button_link}}">{{$sixthSection->button_text}}</a>
            </div>

            <div class="box_image image-block">
                <img src="{{ assetJson([$sixthSection->folder,$sixthSection->image_right]) }}" alt="{{imgAltJson($sixthSection->image_right)}}" title="{{imgTitleJson($sixthSection->image_right)}}">

                <div class="box-detail reveal">
                    <div class="image-wrap">
                        <img src="{{ assetJson([$sixthSection->folder,$sixthSection->image_left]) }}" alt="{{imgAltJson($sixthSection->image_left)}}" title="{{imgTitleJson($sixthSection->image_left)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section_events" id="eventos">
        <svg class="events_line-1" xmlns="http://www.w3.org/2000/svg" width="2" height="1080" viewBox="0 0 2 1080" fill="none">
            <path d="M1 0V1080" stroke="#F1F1F1" stroke-opacity="0.3" />
        </svg>
        <svg class="events_line-2" xmlns="http://www.w3.org/2000/svg" width="2" height="1080" viewBox="0 0 2 1080" fill="none">
            <path d="M1 0V1080" stroke="#F1F1F1" stroke-opacity="0.3" />
        </svg>
        <svg class="events_line-3" xmlns="http://www.w3.org/2000/svg" width="1920" height="1" viewBox="0 0 1920 1" fill="none">
            <path d="M0 0.5H1920" stroke="#F1F1F1" stroke-opacity="0.3" />
        </svg>
        <div class="section_events--container">
            <div class="box_text">
                <span class="box_text--text" data-animation>{{$seventhSection->above_title}}</span>
                <h2 class="box_text--title" data-animation='right'>
                    {!! ignoreTags($seventhSection->title) !!}
                </h2>

                <div class="box_text--description" data-animation>
                    {!! $seventhSection->description !!}
                </div>

                <a class="box_text--link" data-animation='up' href="{{$seventhSection->button_link}}">{{$seventhSection->button_text}}</a>
            </div>

            <div class="box_image image-block">
                <img src="{{ assetJson([$seventhSection->folder,$seventhSection->image]) }}" alt="{{imgAltJson($seventhSection->image)}}" title="{{imgTitleJson($seventhSection->image)}}">

                <div class="box-detail reveal">
                    <div class="image-wrap">
                        <img src="{{ asset('site/img/Home/Investing/Logo.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section_contact" id="contato" data-appearBackToTop>
        <div class="section_contact--container">
            <div class="box_grid">
                <div class="box_text">
                    <span class="box_text--text" data-animation>VAMOS CONVERSAR</span>
                    <h2 class="box_text--title" data-animation='right'>
                        ENTRE EM CONTATO
                    </h2>

                    <div class="box_text--description" data-animation>
                        <p>Use o formulário abaixo para entrar em contato conosco ou apenas para dizer Olá!</p>
                    </div>
                </div>
                @include('site.components.Forms.forms_contact')
            </div>
            <div class="box_image image-block">
                <img data-animation src="{{ asset('site/img/Home/Contact/image-contact.webp') }}" alt="">
            </div>
        </div>

        @include('site.components.Fixed.back_to_top')
    </div>
</section>
@endsection

@section('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/panzoom/panzoom.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/panzoom/panzoom.umd.js"></script>
<script src="{{ asset('site/js/pages/page_home.js') }}"></script>
@endsection
