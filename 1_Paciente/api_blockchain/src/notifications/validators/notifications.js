module.exports.validate_body = validate_body
module.exports.validate_date = validate_date

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

function validate_date(datetime) {
    try {
        return new Date(datetime.replace(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})/, "$2/$1/$3 $4:$5:$6"))
    } catch (e) {
        return null
    }

}