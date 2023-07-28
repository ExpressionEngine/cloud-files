---
sidebar_position: 1
---

# Cloud Files

## Requirements

This add-on requires ExpressionEngine version 7.0.0 or later.
The requirements for this version are [listed here](https://docs.expressionengine.com/v7/installation/requirements.html#recommended-requirements).

Also please note that Cloud Files adapters will not work with file manager [Compatibility Mode](https://docs.expressionengine.com/latest/control-panel/file-manager/file-manager.html#compatibility-mode) turned on.

## Changelog

The changelog provides an account of what changes were made in each version of the Add-on as well as a look at what may be coming in a future release.  You can [view the changelog here on Github](https://github.com/ExpressionEngine/cloud-files/blob/main/CHANGELOG.md).

## Installation

1. Copy the `cloud_files` folder into your `system/user/addons` folder
2. Visit the Control Panel > Developer - Add-Ons page and click the Install button for the Cloud Files add-on

## Basic Usage

After the add-on is installed you can [create a new Upload Directory](https://docs.expressionengine.com/v7/control-panel/file-manager/upload-directories.html#createedit-upload-directory) and you will be given more choices for the **Adapter** field.

## Adapters

This package provides filesystem adapters for the following services.

### Amazon S3

Amazon Simple Storage Service ([Amazon S3](https://aws.amazon.com/s3/)) is an object storage service offering industry-leading scalability, data availability, security, and performance.

Continue reading [here for steps on getting setup with Amazon S3](./adapter-aws-s3.md)

### Cloudflare R2

[Cloudflare R2](https://www.cloudflare.com/products/r2/) allows developers to store large amounts of unstructured data without the costly egress bandwidth fees associated with typical cloud storage services.

Continue reading [here for steps on getting setup with Cloudflare R2](./adapter-cf-r2.md)

### DigitalOcean Spaces

[DigitalOcean Spaces](https://www.digitalocean.com/products/spaces) is an S3-compatible object storage with a built-in CDN that makes data storage and delivery easy, reliable, and affordable.

Continue reading [here for steps on getting setup with DigitalOcean Spaces](./adapter-do-spaces.md)