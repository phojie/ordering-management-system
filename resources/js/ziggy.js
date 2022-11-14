const Ziggy = {
  url: 'http:\/\/rms.test',
  port: null,
  defaults: {},
  routes: {
    'debugbar.openhandler': { uri: '_debugbar\/open', methods: ['GET', 'HEAD'] },
    'debugbar.clockwork': { uri: '_debugbar\/clockwork\/{id}', methods: ['GET', 'HEAD'] },
    'debugbar.assets.css': { uri: '_debugbar\/assets\/stylesheets', methods: ['GET', 'HEAD'] },
    'debugbar.assets.js': { uri: '_debugbar\/assets\/javascript', methods: ['GET', 'HEAD'] },
    'debugbar.cache.delete': { uri: '_debugbar\/cache\/{key}\/{tags?}', methods: ['DELETE'] },
    'ignition.healthCheck': { uri: '_ignition\/health-check', methods: ['GET', 'HEAD'] },
    'ignition.executeSolution': { uri: '_ignition\/execute-solution', methods: ['POST'] },
    'ignition.updateConfig': { uri: '_ignition\/update-config', methods: ['POST'] },
    'dashboard': { uri: 'dashboard', methods: ['GET', 'HEAD'] },
    'register': { uri: 'register', methods: ['GET', 'HEAD'] },
    'login': { uri: 'login', methods: ['GET', 'HEAD'] },
    'password.request': { uri: 'forgot-password', methods: ['GET', 'HEAD'] },
    'password.email': { uri: 'forgot-password', methods: ['POST'] },
    'password.reset': { uri: 'reset-password\/{token}', methods: ['GET', 'HEAD'] },
    'password.update': { uri: 'reset-password', methods: ['POST'] },
    'verification.notice': { uri: 'verify-email', methods: ['GET', 'HEAD'] },
    'verification.verify': { uri: 'verify-email\/{id}\/{hash}', methods: ['GET', 'HEAD'] },
    'verification.send': { uri: 'email\/verification-notification', methods: ['POST'] },
    'password.confirm': { uri: 'confirm-password', methods: ['GET', 'HEAD'] },
    'logout': { uri: 'logout', methods: ['POST'] },
    'users.index': { uri: 'admin\/users', methods: ['GET', 'HEAD'] },
    'users.store': { uri: 'admin\/users', methods: ['POST'] },
    'users.update': { uri: 'admin\/users\/{user}', methods: ['PUT'], bindings: { user: 'id' } },
    'users.destroy': { uri: 'admin\/users\/{user}', methods: ['DELETE'], bindings: { user: 'id' } },
    'users.destroy-multiple': { uri: 'admin\/users', methods: ['DELETE'] },
    'users.restore': { uri: 'admin\/users\/{user}\/restore', methods: ['PUT'], bindings: { user: 'id' } },
    'users.restore-multiple': { uri: 'admin\/users\/restore-multiple', methods: ['PUT'] },
  },
}

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined')
  Object.assign(Ziggy.routes, window.Ziggy.routes)

export { Ziggy }
