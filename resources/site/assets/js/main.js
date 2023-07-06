// FUNÇÕES/MÓDULOS SITE
import newsletter from './modules/newsletter'
import changeLang from './modules/changeLang';
import anchorLinks from './modules/anchor_links';
import FontSize from './modules/Utils/fontSize';
import Footer from './modules/Layouts/footer';
import { Menu } from './modules/Layouts/menu';

new Menu()
Footer()
FontSize()
changeLang();
newsletter();
anchorLinks()

 