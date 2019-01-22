import { Component, OnInit } from '@angular/core';
import { Alert, AlertType } from './model/alert';
import { AlertService } from './alert.service';
 
@Component({
    //moduleId: module.id,
    selector: 'alert',
    templateUrl: 'alert.component.html'
})
 
export class AlertComponent {
    alerts: Alert[] = [];
 
    constructor(private alertService: AlertService) { }
 
    ngOnInit() {
        this.alertService.getAlert().subscribe((alert: Alert) => {
            if (!alert) {
                this.alerts = [];
                return;
            }
            this.alerts.push(alert);
        });
    }
 
    removeAlert(alert: Alert) {
        this.alerts = this.alerts.filter(x => x !== alert);
    }
 
    cssClass(alert: Alert) {
        if (!alert) {
            return;
        }
 
        switch (alert.type) {
            case AlertType.Success:
                return 'spq-alert spq-alert-success';
            case AlertType.Error:
                return 'spq-alert spq-alert-danger';
            case AlertType.Info:
                return 'spq-alert spq-alert-info';
            case AlertType.Warning:
                return 'spq-alert spq-alert-warning';
        }
    }
}