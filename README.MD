# Post SMTP Webhook Notifier

Post SMTP Webhook Notifier is a WordPress plugin that sends a webhook to a Google Chat space when an email fails to send via Post SMTP.

## Description

This plugin is designed to notify a specified Google Chat space whenever an email fails to send. It sends a webhook with details about the error, helping you monitor and troubleshoot email delivery issues on your WordPress site.

## Features

- Sends a webhook to a specified Google Chat space when an email fails to send.
- Includes error details in the webhook message.
- Provides an admin settings page to configure the webhook URL.
- Includes a test button to send a test webhook for verification.

## Installation

1. Download the plugin and upload it to your WordPress site's `wp-content/plugins` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to `Settings` -> `Post SMTP Webhook Notifier` to configure the plugin.

## Configuration

1. Navigate to the plugin settings page via `Settings` -> `Post SMTP Webhook Notifier`.
2. Enter the webhook URL where notifications should be sent.
3. Click 'Save Changes' to save the configuration.

## Testing the Webhook

To test the webhook functionality:

1. Go to `Settings` -> `Post SMTP Webhook Notifier`.
2. Scroll down to the 'Test Webhook' section.
3. Click the 'Send Test Webhook' button.
4. A test webhook will be sent, and a success message will be displayed if the webhook is sent successfully.

## Logging

The plugin logs various messages to the error log to assist with debugging. You can view these logs in your server's error log file.

## Development

To contribute to the development of this plugin:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes.
4. Submit a pull request with a description of your changes.

## Changelog

### 1.0
- Initial release.

## License

This plugin is licensed under the GPL-2.0-or-later license.

## Author

GippsHost
[https://www.gippshost.com.au](https://www.gippshost.com.au)

## Support

For support, please contact [support@gippshost.com.au](mailto:support@gippshost.com.au).
