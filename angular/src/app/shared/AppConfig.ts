import { environment } from '../../environments/environment';

const domain: string = environment.production ? 'https://trendamp.com' : 'http://trendamp.localhost';

export const AppConfig = {
  serverDomain : domain,
  serverApi : domain + '/api',
}
