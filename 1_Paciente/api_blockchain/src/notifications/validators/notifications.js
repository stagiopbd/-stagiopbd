module.exports.validate_body = validate_body

function validate_body(req) {
    req.checkBody("notificationId", "required").notEmpty();
    req.checkBody("type", "required").notEmpty();
    req.checkBody("from", "required").notEmpty();
    req.checkBody("to", "required").notEmpty();
    req.checkBody("datetime", "required").notEmpty();
    req.checkBody("title", "required").notEmpty();
    req.checkBody("text", "required").notEmpty();
    req.checkBody("protocol", "required").notEmpty();
    return req.validationErrors();
}