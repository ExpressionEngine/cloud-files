/// <reference types="Cypress" />

import UploadEdit from '../../elements/pages/files/UploadEdit';
import UploadFile from '../../elements/pages/files/UploadFile';
import FileManager from '../../elements/pages/files/FileManager';
const page = new UploadEdit;
const upload = new UploadFile;
const filemanager = new FileManager;
const keepDebug = Cypress.env('KEEP_DEBUG', false);

const r2_settings = {
    account_id: Cypress.env('CF_R2_ACCOUNT_ID'),
    key: Cypress.env('CF_R2_KEY'),
    secret: Cypress.env('CF_R2_SECRET'),
    bucket: Cypress.env('CF_R2_BUCKET'),
    url: Cypress.env('CF_R2_URL') + '/' + Cypress.env('CF_TEST_FOLDER') + '/',
    folder: Cypress.env('CF_TEST_FOLDER') +'/',
}

context('Cloudflare R2 Adapter Test', () => {

    before(function() {
        cy.task('db:seed')
    })

    it('can create an upload destination with R2 adapter', function() {
        cy.auth()
        page.load()
        cy.intercept("**/files/uploads/**").as("ajax");
        page.get('name').clear().type('R2 Test')

        // Allow all file types
        page.get('allowed_types').find('[value="--"]').check()

        cy.get('[data-input-value=adapter] .select__button').click()
        cy.get('[data-input-value=adapter] .select__dropdown .select__dropdown-item').contains('Cloudflare R2').click()

        // R2 settings
        // Account ID
        cy.get('input[name="_for_adapter[cloudflarer2][adapter_settings][account_id]"]').then(function (el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(r2_settings.account_id, { log: keepDebug })
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Key
        cy.get('input[name="_for_adapter[cloudflarer2][adapter_settings][key]"]').then(function(el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(r2_settings.key, {log: keepDebug})
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Secret
        cy.get('input[name="_for_adapter[cloudflarer2][adapter_settings][secret]"]').then(function(el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(r2_settings.secret, {log: keepDebug})
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Bucket
        cy.get('input[name="_for_adapter[cloudflarer2][adapter_settings][bucket]"]').then(function(el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(r2_settings.bucket, {log: keepDebug})
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Path
        cy.get('input[name="_for_adapter[cloudflarer2][server_path]"]').then(function(el) {
            cy.wrap(el).clear().type(r2_settings.folder, {log: keepDebug})
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // URL
        cy.get('input[name="_for_adapter[cloudflarer2][url]"]').then(function (el) {
            cy.wrap(el).clear().type(r2_settings.url, { log: keepDebug })
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        page.submit()

        // See R2 in Files sidebar
        cy.get('.secondary-sidebar').contains('R2 Test').click()

        // View R2 destination, see error
        cy.should('not.contain', 'Cannot find the directory')

    })

    it('Can upload a file', function() {
        cy.auth()
        page.load()
        cy.get('.secondary-sidebar').contains('R2 Test').click()

        let md_file = 'support/file/README.md'
        upload.dragAndDropUpload(md_file)
        cy.get('.file-upload-widget').should('not.be.visible')
        cy.wait('@table')
        cy.hasNoErrors()

        page.get('selected_file').should('exist')
        page.get('selected_file').contains("README.md")
        page.get('selected_file').should('contain', 'Document')

    })

    it('Can delete a file', function() {
        cy.auth()
        page.load()
        cy.get('.secondary-sidebar').contains('R2 Test').click()


        let filename = '';
        filemanager.get('title_names').eq(0).invoke('text').then((text) => {
            filename = text
        })

        filemanager.get('files').eq(0).find('input[type="checkbox"]').check()

        filemanager.get('bulk_action').select("Delete")
        filemanager.get('action_submit_button').click()

        cy.get('[value="Confirm and Delete"]').filter(':visible').first().click()
        cy.hasNoErrors()

        filemanager.get('wrap').invoke('text').then((text) => {
            expect(text).not.contains(filename)
        })
    })


})