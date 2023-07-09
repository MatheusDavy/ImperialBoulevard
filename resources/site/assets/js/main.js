// FUNÇÕES/MÓDULOS SITE
import newsletter from './modules/newsletter'
import changeLang from './modules/changeLang';
import FontSize from './modules/Utils/fontSize';
import Footer from './modules/Layouts/footer';
import ImageEnter from './modules/Animation/imageEnter';
import ScrollSmooth from './modules/Animation/scrollLenis';
import { Menu } from './modules/Layouts/menu';
import ZoomImages from './modules/Utils/zoom_images';
import AnimationElements from './modules/Animation/enterElements';

changeLang();
newsletter();

new Menu()
Footer()
AnimationElements()
FontSize()
ImageEnter()
ScrollSmooth()
ZoomImages()
