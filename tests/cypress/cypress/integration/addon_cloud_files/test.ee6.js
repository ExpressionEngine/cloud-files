/// <reference types="Cypress" />

import AddonManager from '../../elements/pages/addons/AddonManager';
import UploadEdit from '../../elements/pages/files/UploadEdit';
const addonPage = new AddonManager;
const uploadPage = new UploadEdit;


context('Basic Addon Test', () => {

    before(function() {
        cy.task('db:seed')
    })

    it('can be installed', function() {
        cy.authVisit(addonPage.url);
        addonPage.get('title').contains('Add-Ons')
        cy.get('.add-on-card[data-addon="cloud_files"] .button').contains('Install').click()
        cy.hasNoErrors()
    })

    it('provides new upload destination adapters', function() {
        cy.auth()
        uploadPage.load()

        uploadPage.get('adapter').find('.dropdown').contains('AWS S3')
        uploadPage.get('adapter').find('.dropdown').contains('DigitalOcean Spaces')

    })

    it('can be uninstalled', function() {
        cy.authVisit(addonPage.url);
        addonPage.get('title').contains('Add-Ons')
        cy.get('.add-on-card[data-addon="cloud_files"] .add-on-card__cog').click()
        cy.get('.add-on-card[data-addon="cloud_files"] .dropdown--open').contains('Uninstall').click()
        cy.hasNoErrors()
    })

})