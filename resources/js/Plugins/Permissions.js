const Permissions = {};

Permissions.install = function(Vue, options) {
    //Lo que hacemos es agregar al prototype de vue un obtejo(que es con el que accesados en las template)

    /**
     * [{name: "can create"}, {name: "show own programs", "owner": 1}]
     * @params permissions
     * @returns {boolean}
     */
    //este nuevo obtejo sera como usar $store o $router, de esta forma lo podremos utilizar
    Vue.prototype.$permissions = {
        //Ahora lo que tenemos es un metodo llamado can, es un array de permisos, el cual le pasamos nosotros para saber si un usuario tiene permisos para alguna accion(ver, editar, etc)
        can: (permissions = []) => {
            /**
             * Aqui $page contiene o son los datos que nos ofrece inertia
             * En este cas tenemos acceso a los usuarios identificados, asi podemos acceder a todos las propiedades de usuario
             */
            const user = Vue.prototype.$page.user;
            /**
             * Partimos simulando la puerta de entrada (Gate) Before
             * Si el usuario es Super-Admin, entonces este usuario puede hacer todo!
             */
            if(user.roles[0].name === "Super-Admin") return true;
            /**
             * Para otros casos ya entramos a revisar los permisos
             */

            let can = false;

            /**
             * Hacemos un forEach de permission, en este caso p 
             */
            permissions.forEach(p => {
                const userHasPermission = user.permissions.find(_p => _p.name === p.name);
                /**
                 * Si el usuario tiene permisos 
                 */                
                if(userHasPermission) {
                    /**
                     * Para saber si este usuario es el propietario de este programa
                     * vamos a comprobar si este programa tiene la propiedad owner,
                     * es como si le pasaramos el id del usuario que ha creado el programa
                     */
                    if(p.hasOwnProperty("owner")) {
                        /**
                         * Vamos a comprobar si p.owner es igual a user.id
                         */
                        if(p.owner === user.id) can = true;
                        /**
                         * Tenemos un array con objeto de permisos, su name y el permiso, para los casos de create no pasamos el owner,
                         * pero para los casos que tome un programa que ya existe debemos de pasarle el owner
                         * [{"name": "can create"}, {"name": "show own programs", "owner": 1}]
                         * 
                         */
                    } else {
                        can = true;
                    }
                }
            })
            return can;
        }
    }
}

export default {
    install(app, options) {
        app.config.globalProperties.$can = function (permission) {
            return options.permissions.includes(permission);
        }
    }
}