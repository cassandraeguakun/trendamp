import { Component } from '@angular/core';
import {AuthService} from "../services/auth.service";

@Component({
	selector: 'app-sidebar',
	templateUrl: './sidebar.html',
	styleUrls : ['./sidebar.scss']
})
export class SidebarComponent {
	showMenu: string = '';


    constructor(private authService: AuthService) {
    }

    addExpandClass(element: any) {
		if (element === this.showMenu) {
			this.showMenu = '0';
		} else {
			this.showMenu = element;
		}
	}

	logout(){
		this.authService.logout();
	}
}
