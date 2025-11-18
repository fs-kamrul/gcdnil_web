
import EducationsComponent from './components/EducationsComponent'

if (typeof vueApp !== 'undefined') {
    vueApp.booting((vue) => {
        vue.component('educations-component', EducationsComponent)
    })
}
