import { Question } from './question';

export class Quiz {
  id: string = '';
  title: string = '';
  description: string = '';
  summary: string = '';
  duration: number;
  nextSubmissionAfter: number;
  timeActive: number;
  paginated: boolean;
  perPage: number;
  //marksType: number;
  shuffleQuestions: boolean;
  shuffleAnswers: boolean;
  immediateAnswers: boolean;
  restrictSubmissions: boolean;
  allowedSubmissions: number;      
  questions: Array<Question> = []
}
