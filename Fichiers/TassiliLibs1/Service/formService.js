import { usePage } from '@inertiajs/vue3'
import { TassiliRoutes } from '@/vendor/TassiliLibs/stores/tassiliRoutes'
import {TassiliInput}    from '@/vendor/TassiliLibs/stores/tassiliInput'
import { TassiliBulk } from '@/vendor/TassiliLibs/stores/tassiliBulk'

export function formService() {
  
  function setForm() {
   const page = usePage()
   const tassiliroutes  = TassiliRoutes();
   const tassiliInput = TassiliInput()
   const tassiliBulk = TassiliBulk()

   tassiliroutes.setRoutes(page.props.tassiliSettings.routes)
   tassiliInput.tassiliFormList = page.props.tassiliSettings.tassiliFormList
   tassiliBulk.modalFormList = page.props.tassiliSettings.modalFormList
   tassiliInput.customActionModal = false
   tassiliBulk.bulks = page.props.tassiliSettings.bulks
   tassiliBulk.bulkTabs = page.props.tassiliSettings.bulkTabs
   tassiliBulk.bulkOpens = page.props.tassiliSettings.bulkOpens
  }

  return {
    setForm
  }
}