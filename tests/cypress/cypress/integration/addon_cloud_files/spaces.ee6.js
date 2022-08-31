/// <reference types="Cypress" />

import UploadEdit from '../../elements/pages/files/UploadEdit';
import UploadFile from '../../elements/pages/files/UploadFile';
import FileManager from '../../elements/pages/files/FileManager';
const page = new UploadEdit;
const upload = new UploadFile;
const filemanager = new FileManager;

const spaces_settings = {
    key: Cypress.env('DO_SPACES_KEY'),
    secret: Cypress.env('DO_SPACES_SECRET'),
    region: Cypress.env('DO_SPACES_REGION'),
    space: Cypress.env('DO_SPACES_SPACE'),
    folder: 'cypress/',
}

context('DO Spaces Adapter Test', () => {

    before(function() {
        cy.task('db:seed')
    })

    it('can create an upload destination with Spaces adapter', function() {
        cy.auth()
        page.load()
        cy.intercept("**/files/uploads/**").as("ajax");
        page.get('name').clear().type('Spaces Test')

        // Allow all file types
        page.get('allowed_types').find('[value="--"]').check()

        cy.get('[data-input-value=adapter] .select__button').click()
        cy.get('[data-input-value=adapter] .select__dropdown .select__dropdown-item').contains('DigitalOcean Spaces').click()

        // Spaces settings
        // Key
        cy.get('input[name="_for_adapter[digitalocean][adapter_settings][key]"]').then(function(el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(spaces_settings.key)
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Secret
        cy.get('input[name="_for_adapter[digitalocean][adapter_settings][secret]"]').then(function(el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(spaces_settings.secret)
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Region
        cy.get('div[data-input-value="_for_adapter[digitalocean][adapter_settings][region]"]').then(function(el) {
            el.find('.select__button').click()
                // cy.wait("@ajax")
                // page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).find('.select__dropdown .select__dropdown-item').contains('NYC3 - New York City').click()
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Bucket
        cy.get('input[name="_for_adapter[digitalocean][adapter_settings][space]"]').then(function(el) {
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasError(cy.wrap(el), page.messages.validation.required)
            cy.wrap(el).clear().type(spaces_settings.space)
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        // Path
        cy.get('input[name="_for_adapter[digitalocean][server_path]"]').then(function(el) {
            cy.wrap(el).clear().type(spaces_settings.folder)
            el.trigger('blur')
            cy.wait("@ajax")
            page.hasNoError(cy.wrap(el))
        })

        page.submit()

        // See Spaces in Files sidebar
        cy.get('.secondary-sidebar').contains('Spaces Test').click()

        // View Spaces destination, see error
        cy.should('not.contain', 'Cannot find the directory')

    })

    it('Can upload a file', function() {
        cy.auth()
        page.load()
        cy.get('.secondary-sidebar').contains('Spaces Test').click()

        let md_file = '../../support/file/README.md'
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
        cy.get('.secondary-sidebar').contains('Spaces Test').click()


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