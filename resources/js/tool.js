import { createApp } from 'vue'
import FloatingScrollButtons from './components/FloatingScrollButtons.vue'

Nova.booting((app, store) => {
    const container = document.createElement('div')
    document.body.appendChild(container)

    const floatingApp = createApp(FloatingScrollButtons)
    floatingApp.mount(container)
})
