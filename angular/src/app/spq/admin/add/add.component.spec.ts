import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SpqComponent } from './spq.component';

describe('SpqComponent', () => {
  let component: SpqComponent;
  let fixture: ComponentFixture<SpqComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SpqComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SpqComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
