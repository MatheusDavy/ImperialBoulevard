// FUNÇÕES/MÓDULOS SITE
import newsletter from './modules/newsletter'
import changeLang from './modules/changeLang';
import anchorLinks from './modules/anchor_links';
import FontSize from './modules/Utils/fontSize';
import Footer from './modules/Layouts/footer';
import ImageEnter from './modules/animation/imageEnter';
import ScrollSmooth from './modules/animation/scrollLenis';
import { Menu } from './modules/Layouts/menu';
import zoomImages from './modules/Utils/zoom_images';

changeLang();
newsletter();

new Menu()
Footer()

FontSize()
anchorLinks()
ImageEnter()
ScrollSmooth()
zoomImages()