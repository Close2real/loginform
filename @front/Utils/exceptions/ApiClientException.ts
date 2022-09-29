class ApiClientException extends Error {

	code?: number|string;

	constructor(message?: string, code?: number|string) {
		super(message);
		Object.setPrototypeOf(this, ApiClientException.prototype);
		this.name = "ApiClientException";
		this.code = code;
	}
}

export default ApiClientException;