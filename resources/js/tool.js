import { createApp } from 'vue'
import FloatingScrollButtons from './components/FloatingScrollButtons.vue'

Nova.booting((app, store) => {
    createApp(FloatingScrollButtons).mount(document.createElement('div'))
})
