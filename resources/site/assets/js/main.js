// FUNÇÕES/MÓDULOS SITE
import changeLang from './modules/changeLang';
import FontSize from './modules/Utils/fontSize';
import Footer from './modules/Layouts/footer';
import ImageEnter from './modules/Animation/imageEnter';
import ScrollSmooth from './modules/Animation/scrollLenis';
import { Menu } from './modules/Layouts/menu';
import ZoomImages from './modules/Utils/zoom_images';
import AnimationElements from './modules/Animation/enterElements';
import AnchorLinks from './modules/Utils/anchor_links';
import FormsContact from './modules/Forms/contact';
import Preloader from './modules/Utils/preloader';
import PolicyPrivacy from './modules/Utils/privacyPolicy';

changeLang();
FormsContact();

PolicyPrivacy()

Preloader()
new Menu()
Footer()
AnimationElements()
FontSize()
ImageEnter()
ScrollSmooth()
ZoomImages()
AnchorLinks()
