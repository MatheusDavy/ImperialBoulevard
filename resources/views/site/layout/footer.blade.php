<footer id="footer" class="footer">
	<div class="footer--container item-one">
		<div class="box_text">
			<h3 class="box_text--title">NOSSOS CONTATOS</h3>
			<nav class="box_text--list">
				<ul>
					@if ($empresa->address)
					<li>
						<svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path id="Vector" d="M23.8606 2.54337C24.1433 1.85684 23.9817 1.06647 23.4567 0.54148C22.9318 0.0164889 22.1414 -0.145047 21.4549 0.137641L1.14749 8.4452C0.328278 8.77981 -0.133253 9.64518 0.0340517 10.5105C0.201357 11.3759 0.962882 11.999 1.84556 11.999H11.9992V22.1527C11.9992 23.0353 12.6223 23.7911 13.4877 23.9642C14.353 24.1372 15.2184 23.6699 15.553 22.8507L23.8606 2.54337Z" fill="#F1F1F1" />
						</svg>
							<a href="">
								{!! ignoreTags($empresa->address) !!}
							</a>
					</li>
					@endif
					@if ($empresa->email)
					<li>
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none">
							<path d="M2.25 0C1.00781 0 0 1.00781 0 2.25C0 2.95781 0.332813 3.62344 0.9 4.05L11.1 11.7C11.6344 12.0984 12.3656 12.0984 12.9 11.7L23.1 4.05C23.6672 3.62344 24 2.95781 24 2.25C24 1.00781 22.9922 0 21.75 0H2.25ZM0 5.25V15C0 16.6547 1.34531 18 3 18H21C22.6547 18 24 16.6547 24 15V5.25L13.8 12.9C12.7312 13.7016 11.2688 13.7016 10.2 12.9L0 5.25Z" fill="#F1F1F1" />
						</svg>
							<a href="">
								{{$empresa->email}}
							</a>
					</li>
					@endif
					@if ($empresa->phone)
					<li>
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
							<path d="M7.40729 1.10604C7.06141 0.270532 6.14953 -0.174175 5.27809 0.0639007L1.32514 1.14198C0.543531 1.35759 0 2.06733 0 2.87589C0 13.9891 9.01093 23 20.1241 23C20.9327 23 21.6424 22.4565 21.858 21.6749L22.9361 17.7219C23.1742 16.8505 22.7295 15.9386 21.894 15.5927L17.5816 13.7959C16.8495 13.4905 16.0005 13.7016 15.5019 14.317L13.6871 16.5315C10.5247 15.0357 7.9643 12.4753 6.46847 9.31291L8.68302 7.50264C9.29842 6.99953 9.50954 6.15504 9.20409 5.42284L7.40729 1.11053V1.10604Z" fill="#F1F1F1" />
						</svg>
						<a href="">
							{{$empresa->phone}}
						</a>
					</li>
					@endif
				</ul>
			</nav>
			<div class="box_text--social">
				@if ($empresa->facebook)
				<a href="{{$empresa->facebook}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="74" height="64" viewBox="0 0 74 64" fill="none">

						<path d="M37.0076 23.2828C32.1824 23.2828 28.2904 27.1748 28.2904 32C28.2904 36.8252 32.1824 40.7172 37.0076 40.7172C41.8328 40.7172 45.7248 36.8252 45.7248 32C45.7248 27.1748 41.8328 23.2828 37.0076 23.2828ZM37.0076 37.6673C33.8894 37.6673 31.3403 35.1257 31.3403 32C31.3403 28.8743 33.8818 26.3327 37.0076 26.3327C40.1333 26.3327 42.6749 28.8743 42.6749 32C42.6749 35.1257 40.1257 37.6673 37.0076 37.6673ZM48.1146 22.9263C48.1146 24.0567 47.2042 24.9595 46.0813 24.9595C44.9509 24.9595 44.0481 24.0491 44.0481 22.9263C44.0481 21.8034 44.9585 20.893 46.0813 20.893C47.2042 20.893 48.1146 21.8034 48.1146 22.9263ZM53.8881 24.9898C53.7591 22.2662 53.137 19.8536 51.1417 17.8659C49.154 15.8782 46.7414 15.2561 44.0177 15.1195C41.2106 14.9602 32.7969 14.9602 29.9898 15.1195C27.2738 15.2485 24.8612 15.8706 22.8659 17.8583C20.8706 19.846 20.2561 22.2586 20.1195 24.9823C19.9602 27.7894 19.9602 36.2031 20.1195 39.0102C20.2485 41.7338 20.8706 44.1464 22.8659 46.1341C24.8612 48.1218 27.2662 48.7439 29.9898 48.8805C32.7969 49.0398 41.2106 49.0398 44.0177 48.8805C46.7414 48.7515 49.154 48.1294 51.1417 46.1341C53.1294 44.1464 53.7515 41.7338 53.8881 39.0102C54.0474 36.2031 54.0474 27.7969 53.8881 24.9898ZM50.2616 42.0221C49.6699 43.5091 48.5243 44.6547 47.0297 45.254C44.7916 46.1417 39.4809 45.9369 37.0076 45.9369C34.5343 45.9369 29.216 46.1341 26.9855 45.254C25.4985 44.6623 24.3529 43.5167 23.7535 42.0221C22.8659 39.784 23.0707 34.4733 23.0707 32C23.0707 29.5267 22.8735 24.2084 23.7535 21.9779C24.3453 20.4909 25.4909 19.3453 26.9855 18.746C29.2236 17.8583 34.5343 18.0631 37.0076 18.0631C39.4809 18.0631 44.7992 17.8659 47.0297 18.746C48.5167 19.3377 49.6623 20.4833 50.2616 21.9779C51.1493 24.216 50.9444 29.5267 50.9444 32C50.9444 34.4733 51.1493 39.7916 50.2616 42.0221Z" fill="#D2A671" />
					</svg>
				</a>
				@endif
				@if ($empresa->instagram)
				<a href="{{$empresa->instagram}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="74" height="64" viewBox="0 0 74 64" fill="none">
						<path d="M45.0166 34.125L45.9609 27.9718H40.0567V23.9788C40.0567 22.2954 40.8815 20.6545 43.5258 20.6545H46.2099V15.4157C46.2099 15.4157 43.7741 15 41.4453 15C36.583 15 33.4048 17.9471 33.4048 23.2822V27.9718H28V34.125H33.4048V49H40.0567V34.125H45.0166Z" fill="#D2A671" />
					</svg>
				</a>
				@endif
				@if ($empresa->phone)
				<a href="{{formatWpp($empresa->phone)}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="74" height="64" viewBox="0 0 74 64" fill="none">
						<path d="M48.9076 19.9406C45.7277 16.7531 41.4929 15 36.9924 15C27.7031 15 20.1442 22.5589 20.1442 31.8482C20.1442 34.8156 20.9183 37.7147 22.3906 40.2723L20 49L28.9326 46.6549C31.3915 47.9982 34.1616 48.704 36.9848 48.704H36.9924C46.2741 48.704 54 41.1451 54 31.8558C54 27.3554 52.0875 23.1281 48.9076 19.9406ZM36.9924 45.8656C34.4728 45.8656 32.0062 45.1902 29.8585 43.9152L29.35 43.6116L24.0527 45.0004L25.4643 39.8321L25.1304 39.3009C23.7263 37.0696 22.9902 34.4969 22.9902 31.8482C22.9902 24.1299 29.2741 17.846 37 17.846C40.7415 17.846 44.2554 19.3031 46.8964 21.9518C49.5375 24.6004 51.1616 28.1143 51.154 31.8558C51.154 39.5817 44.7107 45.8656 36.9924 45.8656ZM44.6728 35.3772C44.2554 35.1647 42.1835 34.1478 41.7964 34.0112C41.4094 33.867 41.1286 33.7987 40.8478 34.2237C40.567 34.6487 39.7625 35.5897 39.5121 35.8781C39.2692 36.1589 39.0188 36.1969 38.6013 35.9844C36.1272 34.7473 34.5031 33.7759 32.8714 30.9754C32.4388 30.2317 33.304 30.2848 34.1085 28.6759C34.2451 28.3951 34.1768 28.1522 34.0705 27.9397C33.9643 27.7272 33.1219 25.6554 32.7728 24.8129C32.4313 23.9933 32.0821 24.1071 31.8241 24.092C31.5813 24.0768 31.3004 24.0768 31.0196 24.0768C30.7388 24.0768 30.2835 24.183 29.8964 24.6004C29.5094 25.0254 28.4241 26.0424 28.4241 28.1143C28.4241 30.1862 29.9344 32.1897 30.1393 32.4705C30.3518 32.7513 33.1067 37.0013 37.3339 38.8304C40.0054 39.9839 41.0527 40.0826 42.3884 39.8853C43.2004 39.7638 44.8777 38.8683 45.2268 37.8817C45.5759 36.8951 45.5759 36.0527 45.4696 35.8781C45.371 35.6884 45.0902 35.5821 44.6728 35.3772Z" fill="#D2A671" />
					</svg>
				</a>
				@endif
				@if ($empresa->social)
				<a href="{{$empresa->social}}">
					<svg xmlns="http://www.w3.org/2000/svg" width="74" height="64" viewBox="0 0 74 64" fill="none">
						<g clip-path="url(#clip0_158_193)">
							<path d="M53.2895 23.7405C52.8985 22.2682 51.7464 21.1086 50.2836 20.7151C47.6321 20 37 20 37 20C37 20 26.368 20 23.7164 20.7151C22.2536 21.1087 21.1015 22.2682 20.7105 23.7405C20 26.4092 20 31.9773 20 31.9773C20 31.9773 20 37.5453 20.7105 40.214C21.1015 41.6864 22.2536 42.7976 23.7164 43.1912C26.368 43.9062 37 43.9062 37 43.9062C37 43.9062 47.632 43.9062 50.2836 43.1912C51.7464 42.7976 52.8985 41.6864 53.2895 40.214C54 37.5453 54 31.9773 54 31.9773C54 31.9773 54 26.4092 53.2895 23.7405ZM33.5227 37.0326V26.9219L42.409 31.9774L33.5227 37.0326Z" fill="#D2A671" />
						</g>
						<defs>
							<clipPath id="clip0_158_193">
								<rect width="74" height="63.9062" fill="white" />
							</clipPath>
						</defs>
					</svg>
				</a>
				@endif
			</div>
		</div>

		<div class="box_logos">
			<img class="box_logos--main" src="{{ asset('site/img/Footer/meeting-plus.svg') }}" alt="Logo Meeting Plus">

			<div class="box_logos--group">
				<img src="{{ asset('site/img/Footer/boulevard.png') }}" alt="Logo Boulevard">
				<img src="{{ asset('site/img/Footer/prime.svg') }}" alt="Logo PrimeA">
				<img src="{{ asset('site/img/Footer/vj&j.png') }}" alt="lOGO VJ&J">
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="footer--container item-two">
			<div class="footer-bottom--copyright">
				Copyright © <span class="auto--year"></span> - Todos os direitos reservados
			</div>

			<a href="https://weecom.com.br/" target="_blank">
				<svg class="footer-bottom--weecom" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
					<g opacity="0.5">
						<path d="M21.4059 14.8522C21.1955 14.7059 20.9651 14.5907 20.7218 14.5102C20.4789 14.4281 20.2497 14.346 20.0376 14.2673C19.6626 14.1341 19.2785 14.0277 18.8883 13.9492C18.6796 13.8953 18.4596 13.9036 18.2555 13.9731C18.1855 14.003 18.124 14.0499 18.0768 14.1097C18.0296 14.1695 17.9981 14.2401 17.9853 14.3152C17.9492 14.5414 17.9332 14.7703 17.9374 14.9993V23.8859C17.9544 24.1049 18.0223 24.3169 18.1358 24.505C18.2654 24.7195 18.4406 24.9028 18.6489 25.0421C18.8593 25.1884 19.0897 25.3036 19.333 25.3841C19.5759 25.4662 19.8051 25.5483 20.0171 25.627C20.391 25.7601 20.774 25.8664 21.163 25.9451C21.3729 25.9991 21.594 25.9908 21.7992 25.9211C21.869 25.8908 21.9301 25.8437 21.9772 25.784C22.0244 25.7243 22.0561 25.6539 22.0695 25.5791C22.1055 25.3529 22.1216 25.124 22.1173 24.895V16.0186C22.1004 15.7996 22.0324 15.5876 21.919 15.3995C21.7905 15.1814 21.6153 14.9944 21.4059 14.8522Z" fill="#F1F1F1" />
						<path d="M20 0C16.0444 0 12.1776 1.17298 8.8886 3.37061C5.59962 5.56824 3.03617 8.69181 1.52242 12.3463C0.00866348 16.0008 -0.3874 20.0222 0.384304 23.9018C1.15601 27.7814 3.06082 31.3451 5.85787 34.1421C8.65492 36.9392 12.2186 38.844 16.0982 39.6157C19.9778 40.3874 23.9992 39.9913 27.6537 38.4776C31.3082 36.9638 34.4318 34.4004 36.6294 31.1114C38.827 27.8224 40 23.9556 40 20C40 17.3736 39.4827 14.7728 38.4776 12.3463C37.4725 9.91982 35.9993 7.71503 34.1421 5.85786C32.285 4.00069 30.0802 2.5275 27.6537 1.52241C25.2272 0.517316 22.6264 0 20 0ZM30.4532 24.0739C30.4639 24.1515 30.4565 24.2306 30.4316 24.305C30.4067 24.3793 30.365 24.4469 30.3098 24.5025C30.2545 24.5581 30.1871 24.6002 30.1129 24.6255C30.0388 24.6509 29.9597 24.6587 29.882 24.6485H28.9106C28.3154 24.6485 28.3769 24.1526 28.3769 24.1526V16.2066C28.3871 15.9191 28.316 15.6346 28.1717 15.3857C28.0391 15.1735 27.8645 14.9908 27.6586 14.8486C27.4492 14.7006 27.2186 14.5853 26.9745 14.5066C26.7214 14.4245 26.4934 14.3424 26.2904 14.2603C25.9113 14.1351 25.5238 14.0368 25.1308 13.9661C24.9242 13.9136 24.7069 13.9219 24.5049 13.9901C24.438 14.0227 24.3799 14.0707 24.3353 14.1301C24.2907 14.1896 24.2609 14.2589 24.2483 14.3321C24.2125 14.5583 24.1965 14.7873 24.2004 15.0162V16.8497V24.2004V26.0475C24.2022 26.2403 24.185 26.4328 24.1491 26.6222C24.119 26.7883 24.0661 26.9495 23.9918 27.1011C23.9018 27.2653 23.7863 27.4142 23.6497 27.5423C23.3293 27.8423 22.9331 28.0492 22.5039 28.1409H22.4799C22.0699 28.248 21.6377 28.235 21.2348 28.1033L19.8871 27.6484C19.398 27.4773 18.9431 27.3268 18.5189 27.1934L18.1768 27.06C18.0229 27.0019 17.8964 26.9574 17.8006 26.9266C17.7173 27.1705 17.5738 27.3893 17.3833 27.5628C17.0676 27.8568 16.6806 28.0632 16.2606 28.1615C15.8407 28.2599 15.4023 28.2469 14.9889 28.1238L13.6343 27.6484C13.1463 27.4773 12.6983 27.3268 12.2901 27.1968L11.8009 27.0258C11.606 26.9608 11.4931 26.9198 11.4589 26.9027C11.2517 26.8327 11.0485 26.7516 10.85 26.6598C10.6363 26.56 10.4418 26.4234 10.2754 26.2562C10.088 26.0568 9.93852 25.825 9.83411 25.5721C9.69945 25.2288 9.62985 24.8634 9.62887 24.4946H9.60493V15.8132C9.59427 15.7356 9.60167 15.6565 9.62655 15.5821C9.65143 15.5078 9.69313 15.4402 9.7484 15.3846C9.80367 15.329 9.87102 15.2869 9.94521 15.2616C10.0194 15.2363 10.0984 15.2284 10.1762 15.2386H11.1476C11.7428 15.2386 11.6812 15.7311 11.6812 15.7311V23.6805C11.6716 23.968 11.7427 24.2524 11.8864 24.5014C12.02 24.7128 12.1945 24.8954 12.3995 25.0385C12.6089 25.1865 12.8396 25.3018 13.0836 25.3805C13.3368 25.4626 13.5648 25.5447 13.7677 25.6268C14.1417 25.76 14.5246 25.8663 14.9136 25.9449C15.1202 25.9975 15.3376 25.9892 15.5396 25.921C15.6063 25.8887 15.6642 25.8407 15.7083 25.7811C15.7523 25.7215 15.7813 25.6522 15.7927 25.5789C15.8317 25.3531 15.8489 25.124 15.844 24.8948V23.0614V15.7106C15.844 15.6319 15.844 15.608 15.844 15.5156V13.8533C15.8429 13.6607 15.859 13.4684 15.8919 13.2786C15.9232 13.1123 15.9773 12.9512 16.0527 12.7997C16.1425 12.6364 16.258 12.4886 16.3947 12.3619C16.7176 12.0628 17.1143 11.855 17.544 11.7599C17.7615 11.7094 17.9844 11.6864 18.2076 11.6915C18.4162 11.693 18.623 11.7288 18.8199 11.7975L20.1642 12.273C20.6533 12.444 21.1083 12.5945 21.5324 12.7279L21.8745 12.8613C22.0284 12.9194 22.155 12.9639 22.2507 12.9947C22.334 12.7508 22.4775 12.532 22.668 12.3585C22.9837 12.0645 23.3707 11.8582 23.7907 11.7598C24.2106 11.6614 24.649 11.6744 25.0624 11.7975L26.4033 12.273C26.8936 12.444 27.3417 12.5945 27.7476 12.7245L28.2367 12.8955C28.4317 12.9605 28.5446 13.0015 28.5788 13.0186C28.7859 13.0886 28.9892 13.1697 29.1876 13.2615C29.4019 13.3604 29.5965 13.4971 29.7623 13.6651C29.9496 13.8645 30.0991 14.0963 30.2035 14.3492C30.3382 14.6926 30.4078 15.0579 30.4088 15.4267H30.4327L30.4532 24.0739Z" fill="#F1F1F1" />
					</g>
				</svg>
			</a>
		</div>
	</div>

</footer>