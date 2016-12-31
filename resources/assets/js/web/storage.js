/**
 * Created by hejunwei on 12/30/16.
 */
export default {
	set:function ($key,$value) {
		return window.localStorage.setItem($key,JSON.stringify($value))
	},
	get:function ($key) {
		return JSON.parse(window.localStorage.getItem($key) || '[]')
	}
}